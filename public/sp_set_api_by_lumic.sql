CREATE PROCEDURE sp_set_api_by_lumic( IN `v_vc_proyecto` VARCHAR(64) 
                                      , IN `v_vc_name` TEXT
                                      , IN `v_vc_camel` TEXT
                                      , IN `v_vc_rehacer_bd` VARCHAR(2)
                                      , OUT `v_i_response` INTEGER
                                      )
    MODIFIES SQL DATA
BEGIN

        DECLARE v_vc_proyecto_to_bd VARCHAR(64) DEFAULT "";

        SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

        SET @vc_rehacer= "rehacer-bd-lumic";
        SET v_vc_proyecto_to_bd=    IF (v_vc_proyecto = "abogados" OR v_vc_proyecto="abogadosAdmin", "abogados_produccion"
                                  , IF (v_vc_proyecto = 'test','u733136234_test'
                                    , IF (v_vc_proyecto = 'bt','teiker_qa'
                                            , IF (v_vc_proyecto = 'console','u733136234_console',v_vc_proyecto)
                                    )
                                  )
                                );

        SET v_vc_proyecto:= IF (v_vc_proyecto= 'abogadosAdmin', 'abogados', IF (v_vc_proyecto= 'TeikerQA', 'Teiker_qa', v_vc_proyecto));

        SET @_SQL:= CONCAT ("

              <a href='javascript:void(0);' onclick=\"Api_by_lumic.EliminarBD('",v_vc_proyecto_to_bd,"', '",v_vc_name,"');return false;\" class='btn btn-primary btn-sm' style='margin-left:5%'>
                Del bd
              </a>

              <a href='javascript:void(0);' onclick=\"Api_by_lumic.EliminarProyecto('",v_vc_proyecto,"', '",v_vc_name,"', '",v_vc_camel,"');return false;\" class='btn btn-primary btn-sm '>
                Del ",v_vc_name,"
              </a>

              <a href='javascript:void(0);' id='find_replace'  onclick=\"Api_by_lumic.descargarArchivoApi('",v_vc_proyecto,"', 'form-", v_vc_name, "' , 'text/plain', '", v_vc_name, "'  , 'mysql -u adminBD -pF4I6^\\\\$BDC-aEonn9 ",v_vc_proyecto_to_bd," < /var/www/html/",v_vc_proyecto,"/API_BD/",v_vc_name,".sql');return false;\" 
                class='btn btn-primary btn-sm '
              >
                Cambiar
              </a>

              <a href='#modal_form_reemplazar_tema' data-toggle='modal' class='btn btn-primary btn-sm  reemplazar-tema'  id='reemplazar-tema-form-",v_vc_name,"' >
                R Tema
              </a>

              <a href='http://",v_vc_proyecto,"/",v_vc_camel, "' id-data='",v_vc_proyecto,"' class='btn btn-primary btn-sm vc_proyecto ' target='_blank' > Web </a> 

              <span class='badge bg-success'>",v_vc_proyecto,"</span>

                <div id='text-ssh-",v_vc_name,"' class='d-none hide'>  </div>

                <div id='form-",v_vc_name,"' class='hide-x' data-simplebar data-simplebar-auto-hide='false' data-simplebar-track='danger' style='max-height: 275px;'>
                  <div class='box'>
                    <div class='card-header'>
                        <h5>Establecer valores</h5>
                        <b>",v_vc_name,"</b>
                    </div>
                    <div class='row campos'>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='1' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema1_", v_vc_name , "' value='vTema1_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='1' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo1_", v_vc_name , "' value='vCampo1_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='2' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema2_", v_vc_name , "' value='vTema2_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='2' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo2_", v_vc_name , "' value='vCampo2_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='3' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema3_", v_vc_name , "' value='vTema3_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='3' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo3_", v_vc_name , "' value='vCampo3_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='4' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema4_", v_vc_name , "' value='vTema4_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='4' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo4_", v_vc_name , "' value='vCampo4_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='5' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema5_", v_vc_name , "' value='vTema5_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='5' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo5_", v_vc_name , "' value='vCampo5_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='6' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema6_", v_vc_name , "' value='vTema6_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='6' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo6_", v_vc_name , "' value='vCampo6_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='7' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema7_", v_vc_name , "' value='vTema7_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='7' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo7_", v_vc_name , "' value='vCampo7_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='8' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema8_", v_vc_name , "' value='vTema8_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='8' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo8_", v_vc_name , "' value='vCampo8_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='9' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema9_", v_vc_name , "' value='vTema9_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='9' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo9_", v_vc_name , "' value='vCampo9_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='10' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema10_", v_vc_name , "' value='vTema10_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='10' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo10_", v_vc_name , "' value='vCampo10_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='11' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema11_", v_vc_name , "' value='vTema11_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='11' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo11_", v_vc_name , "' value='vCampo11_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='12' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema12_", v_vc_name , "' value='vTema12_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='12' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo12_", v_vc_name , "' value='vCampo12_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='13' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema13_", v_vc_name , "' value='vTema13_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='13' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo13_", v_vc_name , "' value='vCampo13_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='14' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema14_", v_vc_name , "' value='vTema14_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='14' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo14_", v_vc_name , "' value='vCampo14_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='15' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema15_", v_vc_name , "' value='vTema15_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='15' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo15_", v_vc_name , "' value='vCampo15_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='16' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema16_", v_vc_name , "' value='vTema16_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='16' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo16_", v_vc_name , "' value='vCampo16_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='17' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema17_", v_vc_name , "' value='vTema17_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='17' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo17_", v_vc_name , "' value='vCampo17_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='18' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema18_", v_vc_name , "' value='vTema18_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='18' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo18_", v_vc_name , "' value='vCampo18_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='19' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema19_", v_vc_name , "' value='vTema19_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='19' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo19_", v_vc_name , "' value='vCampo19_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='20' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema20_", v_vc_name , "' value='vTema20_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='20' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo20_", v_vc_name , "' value='vCampo20_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='21' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema21_", v_vc_name , "' value='vTema21_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='21' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo21_", v_vc_name , "' value='vCampo21_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='22' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema22_", v_vc_name , "' value='vTema22_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='22' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo22_", v_vc_name , "' value='vCampo22_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='23' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema23_", v_vc_name , "' value='vTema23_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='23' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo23_", v_vc_name , "' value='vCampo23_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='24' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema24_", v_vc_name , "' value='vTema24_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='24' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo24_", v_vc_name , "' value='vCampo24_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='25' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema25_", v_vc_name , "' value='vTema25_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='25' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo25_", v_vc_name , "' value='vCampo25_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='26' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema26_", v_vc_name , "' value='vTema26_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='26' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo26_", v_vc_name , "' value='vCampo26_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='27' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema27_", v_vc_name , "' value='vTema27_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='27' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo27_", v_vc_name , "' value='vCampo27_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='28' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema28_", v_vc_name , "' value='vTema28_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='28' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo28_", v_vc_name , "' value='vCampo28_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='29' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema29_", v_vc_name , "' value='vTema29_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='29' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo29_", v_vc_name , "' value='vCampo29_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_tema' type='text' data-id='30' data-tipo='Tema' data-name='",v_vc_name,"' id='vTema30_", v_vc_name , "' value='vTema30_", v_vc_name , "'>
                           </div>
                         </div>
                         <div class='col-sm-6 mb-3'>
                           <div class='form-group fill'>
                             <input class='form-control global_filter cambiar_campo' type='text' data-id='30' data-tipo='Campo' data-name='",v_vc_name,"' id='vCampo30_", v_vc_name , "' value='vCampo30_", v_vc_name , "'>
                           </div>
                         </div>
                    </div><!-- /.campos -->
                  </div><!-- /.box -->
                </div><!-- /#form-v_vc_name -->
        ");

        SET @_VC_INFO:= CONCAT ("
        source /var/www/html/",v_vc_proyecto,"/sql.sql
        <br>source /var/www/html/",v_vc_proyecto,"/API_BD/",v_vc_name,".sql

        <a href='",v_vc_proyecto,"/" ,v_vc_name, "/get_" ,v_vc_name, "' target='_blank' > 
            ",v_vc_proyecto,"/get_" ,v_vc_name, "
        </a> 

        <br>
            DELETE FROM console_gt WHERE vc_name like '%",v_vc_name,"%';
        <br>
        <br>

        find -iname " , v_vc_name , "*  -type f -exec rm {} \\;

        ");

        SET v_vc_rehacer_bd:= IF(@_EXISTS = NULL, 'on', v_vc_rehacer_bd);
        IF (@_EXISTS > 0 AND v_vc_rehacer_bd='on') THEN BEGIN
          UPDATE console_gt SET b_status= 1, vc_name= @_SQL WHERE vc_nombre_api= v_vc_name LIMIT 1;
        END; END IF;

      SET @_QUERY:= CONCAT("SELECT COUNT(*) INTO @ya_existe FROM console_gt WHERE vc_nombre_api= '",v_vc_name,"' AND vc_proyecto= '",v_vc_proyecto,"' AND b_status > 0;") ;
      PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

        IF (@ya_existe = 0) THEN BEGIN
          INSERT INTO console_gt( vc_proyecto, vc_nombre_api, vc_name, vc_info )
          SELECT v_vc_proyecto, v_vc_name, @_SQL , @_VC_INFO 
          FROM DUAL WHERE TRUE;
          SET v_i_response := LAST_INSERT_ID();
        END; END IF;


  END
  