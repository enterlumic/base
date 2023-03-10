<?php
    $env= file_get_contents("../../../../../../../.env");
    $env= explode("\n", $env);


    foreach ($env as $key => $value) {
        
        $get_key= explode("=", $value);

        if ($get_key[0] == "DB_HOST") $DB_HOST= trim($get_key[1]);
        if ($get_key[0] == "DB_DATABASE") $DB_DATABASE= trim($get_key[1]);
        if ($get_key[0] == "DB_USERNAME") $DB_USERNAME= trim($get_key[1]);
        if ($get_key[0] == "DB_PASSWORD") $DB_PASSWORD= trim($get_key[1]);
        if ($get_key[0] == "MAIL_USERNAME") $MAIL_USERNAME= trim($get_key[1]);
        if ($get_key[0] == "MAIL_PASSWORD") $MAIL_PASSWORD= trim($get_key[1]);

    }

    $password= $DB_PASSWORD;
    $database= $DB_DATABASE;
    $username= $DB_USERNAME;

    // FIN CONFIGAUCIÓN ESPECIAL
    $get_list = json_decode($_POST['list'], true);

    include('../../../src/php/class.fileuploader.php');
    // mysqli connection
    $DB = mysqli_connect('localhost', $username, $password, $database);

    // file_put_contents("/var/www/html/crm/lanyz", $password ."--" .$database ."--". $username. "\n" , FILE_APPEND);

    $uploadDir = 'uploads/cliente/'.$_POST['id_cliente']."/";
    $realUploadDir = '../../../../../../../public/uploads/cliente/'.$_POST['id_cliente']."/";

    if (!file_exists( $realUploadDir ))
        mkdir( $realUploadDir, 0777, true);

    $_action = isset($_GET['type']) ? $_GET['type'] : '';

    function getRealFile($file) {
        global $uploadDir, $realUploadDir;
        return str_replace($uploadDir, $realUploadDir, $file);
    }

    // upload
    if ($_action == 'upload') {
        
        $id = false;
        $title = 'auto';

        // if after editing
        if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['_editorr'])) {
            $_id = $DB->real_escape_string($_POST['id']);
            
            $query = $DB->query("SELECT file FROM clientes_adjuntos WHERE id = '$_id'");
            if ($query && $query->num_rows == 1) {
                $row = $query->fetch_assoc();
                $id = $_id;
                $pathinfo = pathinfo($row['file']);
                
                $realUploadDir = getRealFile($pathinfo['dirname'] . '/');
                $title = $pathinfo['filename'];
            } else {
                exit;
            }
        }

        // initialize FileUploader
        $FileUploader = new FileUploader('files', array(
            'limit' => 1,
            'fileMaxSize' => 20,
            'extensions' => array('image/*', 'video/*', 'audio/*'),
            'uploadDir' => $realUploadDir,
            'required' => true,
            'title' => $title,
            'replace' => $id,
            'editor' => array(
                'maxWidth' => 1980,
                'maxHeight' => 1980,
                'crop' => false,
                'quality' => 90
            )
        ));

        $upload = $FileUploader->upload();


        if (count($upload['files']) == 1) {
            $item = $upload['files'][0];
            $title =$DB->real_escape_string($item['name']);
            $type = $DB->real_escape_string($item['type']);
            $size = $DB->real_escape_string($item['size']);
            $file = $DB->real_escape_string($uploadDir . $item['name']);

            if (!$id){
                $query = $DB->query("INSERT INTO clientes_adjuntos(`id_cliente`, `title`, `file`, `type`, `size`, `index`, `date`) VALUES( ".intval($_REQUEST['id_cliente']).", '$title', '$file', '$type', '$size', 1 + (SELECT IFNULL((SELECT MAX(`index`) FROM clientes_adjuntos g), -1)), NOW())");
            }

            else{
                $query = $DB->query("UPDATE clientes_adjuntos SET `size` = '$size' WHERE id = '$id'");
            }

            if ($id || $query) {
                $upload['files'][0] = array(
                    'title' => $item['title'],
                    'name' => $item['name'],
                    'size' => $item['size'],
                    'size2' => $item['size2'],
                    'url' => $file,
                    'id' => $id ? $id : $DB->insert_id
                );
            } else {
                if (is_file($item['file']))
                    @unlink($item['file']);
                unset($upload['files'][0]);
                $upload['hasWarnings'] = true;
                $upload['warnings'][] = 'An error occured.';
            }
        }

            file_put_contents("/var/www/html/crm/lanyz",  $query . "\n" , FILE_APPEND);

        echo json_encode($upload);
        exit;
    }
    
    // preload
    if ($_action == 'preload' && isset($_REQUEST['id_cliente']) && $_REQUEST['id_cliente'] > 0) {
        $preloadedFiles = array();

        $query = $DB->query("SELECT * FROM clientes_adjuntos WHERE id_cliente= ".$_REQUEST['id_cliente']." ORDER BY `index` ASC");

        if ($query && $query->num_rows > 0) {
            while($row = $query->fetch_assoc()) {
                $preloadedFiles[] = array(
                    'name' => $row['title'],
                    'type' => $row['type'],
                    'size' => $row['size'],
                    'file' => $row['file'],
                    'data' => array(
                        'readerForce' => true,
                        'url' => $row['file'],
                        'date' => $row['date'],
                        'isMain' => $row['is_main'],
                        'listProps' => array(
                            'id' => $row['id'],
                        )
                    ),
                );
            }
        }

        echo json_encode($preloadedFiles);
        exit;
    }
    
    // resize
    if ($_action == 'resize') {
        if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['_editor'])) {
            $id = $DB->real_escape_string($_POST['id']);
            $editor = json_decode($_POST['_editor'], true);
            
            $query = $DB->query("SELECT file FROM clientes_adjuntos WHERE id = '$id'");
            if ($query && $query->num_rows == 1) {
                $row = $query->fetch_assoc();
                $file = getRealFile($row['file']);
                
                if (is_file($file)) {
                    $info = Fileuploader::resize($file, null, null, null, (isset($editor['crop']) ? $editor['crop'] : null), 100, (isset($editor['rotation']) ? $editor['rotation'] : null));
                    $size = filesize($file);
                    
                    $DB->query("UPDATE clientes_adjuntos SET `size` = '$size' WHERE id = '$id'");
                }
                
            }
        }
        
        exit;
    }

    // sort
    if ($_action == 'sort') {
        if (isset($_POST['list'])) {
            $list = json_decode($_POST['list'], true);
            
            $index = 0;
            foreach($list as $val) {
                if (!isset($val['id']) || !isset($val['name']) || !isset($val['index']))
                    break;
                
                $id = $DB->real_escape_string($val['id']);
                $DB->query("UPDATE clientes_adjuntos SET `index` = '$index' WHERE id = '$id'");
                $index++;
            }
        }
        exit;
    }

    // rename
    if ($_action == 'rename') {
        if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['title'])) {
            $id = $DB->real_escape_string($_POST['id']);
            $title = substr(FileUploader::filterFilename($_POST['title']), 0, 200);
            
            $query = $DB->query("SELECT file FROM clientes_adjuntos WHERE id = '$id'");
            if ($query && $query->num_rows == 1) {
                $row = $query->fetch_assoc();
                $file = $row['file'];
                
                $pathinfo = pathinfo($file);
                $newName = $title . (isset($pathinfo['extension']) ? '.' . $pathinfo['extension'] : '');
                $newFile = $pathinfo['dirname'] . '/' . $newName;
                
                $realFile = str_replace($uploadDir, $realUploadDir, $file);
                $newRealFile = str_replace($uploadDir, $realUploadDir, $newFile);

                if (!file_exists($newRealFile) && rename($realFile, $newRealFile)) {
                    $query = $DB->query("UPDATE clientes_adjuntos SET `title` = '".$DB->real_escape_string($newName)."', `file` = '".$DB->real_escape_string($newFile)."' WHERE id = '$id'");
                    if ($query) {
                        echo json_encode([
                            'title' => $title,
                            'file' => $newFile,
                            'url' => $newFile
                        ]);
                    }
                }

            }
        }
        exit;
    }

    // asmain
    if ($_action == 'asmain') {
        if (isset($_POST['id']) && isset($_POST['name'])) {
            
            $id = $DB->real_escape_string($_POST['id']);
            
            
            $query = $DB->query("UPDATE clientes_adjuntos SET is_main = 0 WHERE id_cliente = " . $_REQUEST['id_cliente']);
            $query = $DB->query("UPDATE clientes_adjuntos SET is_main = 1 WHERE id = '$id'");

        }
        exit;
    }

    // remove
    if ($_action == 'remove') {
        if (isset($_POST['id']) && isset($_POST['name'])) {
            $id = $DB->real_escape_string($_POST['id']);
            
            $query = $DB->query("SELECT file FROM clientes_adjuntos WHERE id = '$id'");
            
            if ($query && $query->num_rows == 1) {
                $row = $query->fetch_assoc();
                $file = str_replace($uploadDir, $realUploadDir, $row['file']);
                
                $DB->query("DELETE FROM clientes_adjuntos WHERE id = '${id}'");
                if (is_file($file))
                    unlink($file);
            }
        }
        exit;
    }