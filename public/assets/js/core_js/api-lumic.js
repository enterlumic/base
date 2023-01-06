var Api_by_lumic = {

    init: function(){
        Api_by_lumic.eventos();
        Api_by_lumic.ReplaceUpdate();
        Api_by_lumic.CrearCore();
        Api_by_lumic.editor();
        Api_by_lumic.datatable();
        Api_by_lumic.update_api_by_lumic();
        Api_by_lumic.set_Reemplazar_tema();

    },

    html: function(i) {
        return "<div class='col-sm-6'>\
                    <div class='form-group fill'>\
                        <input class='form-control global_filter' type='text' data-id='" + i + "' data-tipo='Tema' data-name='\",v_vc_name,\"' id='vTema" + i + "_\", v_vc_name , \"' value='vTema" + i + "_\", v_vc_name , \"'   >\
                    </div>\
                </div>\
                <div class='col-sm-6'>\
                    <div class='form-group fill'>\
                        <input class='form-control global_filter' type='text' data-id='" + i + "' data-tipo='Campo' data-name='\",v_vc_name,\"' id='vCampo" + i + "_\", v_vc_name , \"' value='vCampo" + i + "_\", v_vc_name , \"'>\
                    </div>\
                </div>";
    },

    editor: function() {
        var valor = '';

        for (var i = 1; i <= 30; i += 1) {
            var a = Api_by_lumic.html(i);
            valor += a;
        }

        $("#campos").val(valor);

        if ($("#vc_description_update").length)
            $("#vc_description_update").Editor();

        $("#agregar-nota").click(function() {
            $("#vc_name_update").val("");
            $("#form_notes_update Editor-editor").html("");
        });

        $(document).keyup(function(e) {
            if (e.key === "Escape")
                $("#cerrar-modal").click();
        });

        $(document).on('keydown', function(e) {
            if (e.ctrlKey && e.which === 83) {
                e.preventDefault();
                return false;
            }
        });
    },

    datatable: function() {

        var table = $('#tb-datatable-api_by_lumic').DataTable({
            "sDom": "<'row'<'col-sm-6'<'dt_actions'>l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
            "stateSave": false,
            "pageLength": 50,
            "scrollCollapse": true,
            "lengthMenu": [10, 25, 50, 75, 100],
            "ajax": "get_api_by_lumic",
            "scrollY":"300px",
            "scrollX": true,
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            "columnDefs": [{
                    "targets": [0],
                    "visible": true,
                    "width": "5%"
                }
                , {
                    "targets": 1,
                    "render": function(data, type, row, meta) {
                        var btn =   '<a href="#modal_form_update" data-toggle="modal" data-id="' + row[0] + '"  class="text-success p-1 update-api_by_lumic">\
                                            <i class="bx bxs-edit-alt"></i>\
                                    </a>\
                                    <a href="javascript:void(0);" id="' + row[0] + '" class="text-danger p-1 delete-api_by_lumic"><i class="bx bxs-trash"></i></a>';
                        return btn + row[1];
                    }
                }
                , {
                    "targets": +2,
                    "visible": false,
                    "width": "5%",
                    "defaultContent": ""
                }
            ]
        });

        $('#tb-datatable-api_by_lumic tbody').on('click', '.update-api_by_lumic', function() {
            var id = $(this).attr("data-id");

            $("#id").val(id);

            $.ajax({
                url:"api_by_id",
                data: { 'id': id },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                success: function(response)
                {
                    $("#form_apy_by_lumic_update .Editor-editor").html(response['vc_name']);
                }
            });

        });

        $('#tb-datatable-api_by_lumic tbody').on('click', '.delete-api_by_lumic', function() {
            var id = this.id;

            $.ajax({
                url:"delete_api_by_lumic",
                data: { 'id': id },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                success: function(response)
                {
                    $('#tb-datatable-api_by_lumic').DataTable().ajax.reload();                    
                    console.log("response", response);
                }
            });


        });
    },

    update_api_by_lumic: function() {

        $("#form_apy_by_lumic_update").validate({
            submitHandler: function(form) {

                var id = $("#id").val();
                var vc_description_update = $("#form_apy_by_lumic_update .Editor-editor").html();

                if (id > 0) {
                    $.ajax({
                        url:"set_update_api_by_lumic",
                        data: {"id": id, "vc_description_update": vc_description_update },
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        type: 'POST',
                        success: function(response)
                        {
                            $('#tb-datatable-api_by_lumic').DataTable().ajax.reload();
                            $("#form_apy_by_lumic_update .close").click();
                        }
                    });
                } else {
                    alert("Es posible que la nota ya no existe, favor de revisar");
                }
            }
        });
    },

    descargarArchivoApi: function(proyecto, text, fileType, fileName, mySQL) {
        
        Api_by_lumic.xxxxxx();

        $("#find_replace").addClass("disabled").text("Cambiando...");

        $("#text-ssh-" + fileName).html("");
        var attr;
        $('#' + text + ' input').each(
            function(index) {
                var input = $(this);
                var data = typeof input.attr('data-grep') !== 'undefined' ? input.attr('data-grep') : "";
                index = index + 1;
                $("#text-ssh-" + fileName).append(data);
            }
        );

        $.ajax({
            url:"guardar_sh",
            data: {"fileName": fileName, "textSSH": "cd /var/www/html/" + proyecto + " \n" + $("#text-ssh-" + fileName).html() + "\n" + mySQL },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            success: function(response)
            {
                $("#find_replace").removeClass("disabled").text("Cambiar");
                $(this).removeClass("disabled");
            }
        });

    },

    EliminarProyecto: function(proyecto, fileName, fileName2) {

        $.ajax({
            url:"eliminar_proyecto",
            data: {"proyecto": proyecto, "fileName": fileName, "fileName2": fileName2 },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            success: function(data)
            {
                Api_by_lumic.notify(data, 'inverse');
            }
        });
    },

    EliminarBD: function(proyecto, nombre_tabla) {
        $.ajax({
            url:"eliminar_bd",
            data: {"proyecto": proyecto, "nombre_tabla": nombre_tabla },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
                success: function(data)
                {
                    Api_by_lumic.notify(data, 'inverse');
                }
        });
    },

    CrearCore: function(proyecto, nombre_tabla) {
        $("#crear-core").validate({
            submitHandler: function(form) {

                var get_form = document.getElementById("crear-core");
                var postData = new FormData(get_form);

                $.ajax({
                    url: "APPLICATION_EXECUTE",
                    data: postData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    success: function(response) {

                        Api_by_lumic.notify(response, 'inverse');

                        Api_by_lumic.xxxxxx();

                        $("#tb-datatable-api_by_lumic").DataTable().search($("#name_strtolower").val()).draw();
                        $("#crear-nuevo").attr("disabled", false);
                        $('#tb-datatable-api_by_lumic').DataTable().ajax.reload();

                    }
                });
            }
        });
    },

    notify: function(message, type) {
        $(".alert").remove();

        $.notify({
            message: message
        }
        , {
            type: type,
            allow_dismiss: false,
            label: 'Cancel',
            className: 'btn-xs btn-inverse',
            placement: {
                from: 'top',
                align: 'right'
            },
            delay: 2500,
            offset: {
                x: 30,
                y: 0
            }
        });
    },
    
    ReplaceUpdate: function() {
        $(document).on("keyup", ".Editor-editor .global_filter", function() {
            var v_id = $(".Editor-editor #" + this.id).attr("data-id");
            var v_vc_name = $(".Editor-editor #" + this.id).attr("data-name");
            var v_tipo = $(".Editor-editor #" + this.id).attr("data-tipo");
            var valDataGrep = "grep -wrl 'v" + v_tipo + v_id + "_" + v_vc_name + "' ./ | xargs sed -i 's/v" + v_tipo + v_id + "_" + v_vc_name + "/" + $(this).val() + "/g' \n";

            $(".Editor-editor #" + this.id).attr("data-grep", valDataGrep);
            $(".Editor-editor #" + this.id).attr("value", $(this).val());
        });
    },

    xxxxxx: function() {

        var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function(name) {
         return typeof name;
        } : function(obj) {
         return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
        };
        !function() {
         function __bind(fn, me) {
           return function() {
             return fn.apply(me, arguments);
           };
         }
         function EventChannel() {
         }
         function CoffeeSpinner() {
           return CoffeeSpinner.__super__.constructor.apply(this, arguments);
         }
         function Bar() {
           this.progress = 0;
         }
         function module() {
           this.bindings = {};
         }
         function RequestIntercept() {
           var _createClass;
           var _this = this;
           RequestIntercept.__super__.constructor.apply(this, arguments);
           _createClass = function monitorXHR(r) {
             var o = r.open;
             return r.open = function(type, id, psc) {
               return shouldTrack(type) && _this.trigger("request", {
                 type : type,
                 url : id,
                 request : r
               }), o.apply(r, arguments);
             };
           };
           window.XMLHttpRequest = function(e) {
             e = new _XMLHttpRequest(e);
             return _createClass(e), e;
           };
           try {
             extendNative(window.XMLHttpRequest, _XMLHttpRequest);
           } catch (t) {
           }
           if (null != _XDomainRequest) {
             window.XDomainRequest = function() {
               var n = new _XDomainRequest;
               return _createClass(n), n;
             };
             try {
               extendNative(window.XDomainRequest, _XDomainRequest);
             } catch (t) {
             }
           }
           if (null != _WebSocket && options.ajax.trackWebSockets) {
             window.WebSocket = function(url, protocols) {
               var SEARCH_REQUEST = null != protocols ? new _WebSocket(url, protocols) : new _WebSocket(url);
               return shouldTrack("socket") && _this.trigger("request", {
                 type : "socket",
                 url : url,
                 protocols : protocols,
                 request : SEARCH_REQUEST
               }), SEARCH_REQUEST;
             };
             try {
               extendNative(window.WebSocket, _WebSocket);
             } catch (t) {
             }
           }
         }
         function AjaxMonitor() {
           this.complete = __bind(this.complete, this);
           var this_ = this;
           this.elements = [];
           getIntercept().on("request", function() {
             return this_.watch.apply(this_, arguments);
           });
         }
         function Tour(options) {
           var selector;
           var _j;
           var _ref;
           var _ref2;
           if (null == options) {
             options = {};
           }
           this.complete = __bind(this.complete, this);
           this.elements = [];
           if (null == options.selectors) {
             options.selectors = [];
           }
           _j = 0;
           _ref = (_ref2 = options.selectors).length;
           for (; _j < _ref; _j++) {
             selector = _ref2[_j];
             this.elements.push(new Model(selector, this.complete));
           }
         }
         function ElementTracker(rule, selector) {
           this.selector = rule;
           this.completeCallback = selector;
           this.progress = 0;
           this.check();
         }
         function DocumentMonitor() {
           var _onreadystatechange;
           var _ref2;
           var _this = this;
           this.progress = null != (_ref2 = this.states[document.readyState]) ? _ref2 : 100;
           _onreadystatechange = document.onreadystatechange;
           document.onreadystatechange = function() {
             return null != _this.states[document.readyState] && (_this.progress = _this.states[document.readyState]), "function" == typeof _onreadystatechange ? _onreadystatechange.apply(null, arguments) : void 0;
           };
         }
         function Scaler(source) {
           this.source = source;
           this.last = this.sinceLastUpdate = 0;
           this.rate = options.initialRate;
           this.catchup = 0;
           this.progress = this.lastProgress = 0;
           if (null != this.source) {
             this.progress = result(this.source, "progress");
           }
         }
         var ajax;
         var ProgressBar;
         var Model;
         var Module;
         var NoTargetError;
         var Pace;
         var Zip;
         var SOURCE_KEYS;
         var Set;
         var TimedMoveable;
         var Moveable;
         var cb;
         var svg;
         var avgAmplitude;
         var bar;
         var guard;
         var transform;
         var defaultOptions;
         var extend;
         var extendNative;
         var getFromDOM;
         var getIntercept;
         var mergePathComponents;
         var ignoreStack;
         var breatheGate;
         var now;
         var options;
         var done;
         var result;
         var draw;
         var handle;
         var getSource;
         var shouldTrack;
         var source;
         var sources;
         var uniScaler;
         var _WebSocket;
         var _XDomainRequest;
         var _XMLHttpRequest;
         var _j;
         var v;
         var _len;
         var _pushState;
         var _ref;
         var _replaceState;
         var message;
         var slice = [].slice;
         var hasProp = {}.hasOwnProperty;
         var __extends = function __extends(child, parent) {
           function ctor() {
             this.constructor = child;
           }
           var key;
           for (key in parent) {
             if (hasProp.call(parent, key)) {
               child[key] = parent[key];
             }
           }
           return ctor.prototype = parent.prototype, child.prototype = new ctor, child.__super__ = parent.prototype, child;
         };
         var __indexOf = [].indexOf || function(q) {
           var p = 0;
           var len = this.length;
           for (; p < len; p++) {
             if (p in this && this[p] === q) {
               return p;
             }
           }
           return -1;
         };
         defaultOptions = {
           className : "",
           catchupTime : 100,
           initialRate : .03,
           minTime : 250,
           ghostTime : 100,
           maxProgressPerFrame : 20,
           easeFactor : 1.25,
           startOnPageLoad : true,
           restartOnPushState : true,
           restartOnRequestAfter : 500,
           target : "body",
           elements : {
             checkInterval : 100,
             selectors : ["body"]
           },
           eventLag : {
             minSamples : 10,
             sampleCount : 3,
             lagThreshold : 3
           },
           ajax : {
             trackMethods : ["GET"],
             trackWebSockets : true,
             ignoreURLs : []
           }
         };
         now = function generateUUID_() {
           var t;
           return null != (t = "undefined" != typeof performance && null !== performance && "function" == typeof performance.now ? performance.now() : void 0) ? t : +new Date;
         };
         done = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
         transform = window.cancelAnimationFrame || window.mozCancelAnimationFrame;
         cb = function init(obj, name, value) {
           if ("function" == typeof obj.addEventListener) {
             return obj.addEventListener(name, value, false);
           }
           var element;
           if ("function" != typeof obj["on" + name] || "object" != _typeof(obj["on" + name].eventListeners)) {
             element = new Module;
             if ("function" == typeof obj["on" + name]) {
               element.on(name, obj["on" + name]);
             }
             obj["on" + name] = function(node) {
               return element.trigger(name, node);
             };
             obj["on" + name].eventListeners = element;
           } else {
             element = obj["on" + name].eventListeners;
           }
           element.on(name, value);
         };
         if (null == done) {
           done = function R(a) {
             return setTimeout(a, 50);
           };
           transform = function clearImmediate(id) {
             return clearTimeout(id);
           };
         }
         draw = function buffer(fn) {
           var start = now();
           var r = function r() {
             var elapsed = now() - start;
             return 33 <= elapsed ? (start = now(), fn(elapsed, function() {
               return done(r);
             })) : setTimeout(r, 33 - elapsed);
           };
           return r();
         };
         result = function innerMapJSONValues() {
           var mix = arguments[0];
           var key = arguments[1];
           var e = 3 <= arguments.length ? slice.call(arguments, 2) : [];
           return "function" == typeof mix[key] ? mix[key].apply(mix, e) : mix[key];
         };
         extend = function innerMapJSONValues() {
           var key;
           var hash;
           var value;
           var target = arguments[0];
           var hashes = 2 <= arguments.length ? slice.call(arguments, 1) : [];
           var i = 0;
           var l = hashes.length;
           for (; i < l; i++) {
             if (hash = hashes[i]) {
               for (key in hash) {
                 if (hasProp.call(hash, key)) {
                   value = hash[key];
                   if (null != target[key] && "object" == _typeof(target[key]) && null != value && "object" == (typeof value === "undefined" ? "undefined" : _typeof(value))) {
                     extend(target[key], value);
                   } else {
                     target[key] = value;
                   }
                 }
               }
             }
           }
           return target;
         };
         avgAmplitude = function onAnalogRead(x) {
           var j;
           var i;
           var s = j = 0;
           var n = 0;
           var l = x.length;
           for (; n < l; n++) {
             i = x[n];
             s = s + Math.abs(i);
             j++;
           }
           return s / j;
         };
         getFromDOM = function getFromDOM(key, json) {
           var data;
           var el;
           if (null == key && (key = "options"), null == json && (json = true), el = document.querySelector("[data-pace-" + key + "]")) {
             if (data = el.getAttribute("data-pace-" + key), !json) {
               return data;
             }
             try {
               return JSON.parse(data);
             } catch (ChangeSetName) {
               return "undefined" != typeof console && null !== console ? console.error("Error parsing inline pace options", ChangeSetName) : void 0;
             }
           }
         };
         EventChannel.prototype.on = function(name, event, context, once) {
           var _base;
           return null == once && (once = false), null == this.bindings && (this.bindings = {}), null == (_base = this.bindings)[name] && (_base[name] = []), this.bindings[name].push({
             handler : event,
             ctx : context,
             once : once
           });
         };
         EventChannel.prototype.once = function(name, type, callback) {
           return this.on(name, type, callback, true);
         };
         EventChannel.prototype.off = function(name, handler) {
           var i;
           var bindings;
           var _results;
           if (null != (null != (bindings = this.bindings) ? bindings[name] : void 0)) {
             if (null == handler) {
               return delete this.bindings[name];
             }
             i = 0;
             _results = [];
             for (; i < this.bindings[name].length;) {
               if (this.bindings[name][i].handler === handler) {
                 _results.push(this.bindings[name].splice(i, 1));
               } else {
                 _results.push(i++);
               }
             }
             return _results;
           }
         };
         EventChannel.prototype.trigger = function() {
           var ctx;
           var handler;
           var i;
           var bindings;
           var node;
           var results;
           var name = arguments[0];
           var thisHandlerArgs = 2 <= arguments.length ? slice.call(arguments, 1) : [];
           if (null != (bindings = this.bindings) && bindings[name]) {
             i = 0;
             results = [];
             for (; i < this.bindings[name].length;) {
               handler = (node = this.bindings[name][i]).handler;
               ctx = node.ctx;
               node = node.once;
               handler.apply(null != ctx ? ctx : this, thisHandlerArgs);
               if (node) {
                 results.push(this.bindings[name].splice(i, 1));
               } else {
                 results.push(i++);
               }
             }
             return results;
           }
         };
         message = EventChannel;
         Pace = window.Pace || {};
         window.Pace = Pace;
         extend(Pace, message.prototype);
         options = Pace.options = extend({}, defaultOptions, window.paceOptions, getFromDOM());
         _j = 0;
         _len = (_ref = ["ajax", "document", "eventLag", "elements"]).length;
         for (; _j < _len; _j++) {
           if (true === options[source = _ref[_j]]) {
             options[source] = defaultOptions[source];
           }
         }
         message = Error;
         __extends(CoffeeSpinner, message);
         NoTargetError = CoffeeSpinner;
         Bar.prototype.getElement = function() {
           var body;
           if (null == this.el) {
             if (!(body = document.querySelector(options.target))) {
               throw new NoTargetError;
             }
             this.el = document.createElement("div");
             this.el.className = "pace pace-active";
             document.body.className = document.body.className.replace(/(pace-done )|/, "pace-running ");
             var opt_by = "" !== options.className ? " " + options.className : "";
             this.el.innerHTML = '<div class="pace-progress' + opt_by + '">\n  <div class="pace-progress-inner"></div>\n</div>\n<div class="pace-activity"></div>';
             if (null != body.firstChild) {
               body.insertBefore(this.el, body.firstChild);
             } else {
               body.appendChild(this.el);
             }
           }
           return this.el;
         };
         Bar.prototype.finish = function() {
           var el = this.getElement();
           return el.className = el.className.replace("pace-active", "pace-inactive"), document.body.className = document.body.className.replace("pace-running ", "pace-done ");
         };
         Bar.prototype.update = function(progress) {
           return this.progress = progress, Pace.trigger("progress", progress), this.render();
         };
         Bar.prototype.destroy = function() {
           try {
             this.getElement().parentNode.removeChild(this.getElement());
           } catch (_error) {
             NoTargetError = _error;
           }
           return this.el = void 0;
         };
         Bar.prototype.render = function() {
           var element;
           var name;
           var t;
           var vertexAttribute;
           var _i;
           var _ref;
           var _ref2;
           if (null == document.querySelector(options.target)) {
             return false;
           }
           element = this.getElement();
           vertexAttribute = "translate3d(" + this.progress + "%, 0, 0)";
           _i = 0;
           _ref = (_ref2 = ["webkitTransform", "msTransform", "transform"]).length;
           for (; _i < _ref; _i++) {
             name = _ref2[_i];
             element.children[0].style[name] = vertexAttribute;
           }
           return (!this.lastRenderedProgress || this.lastRenderedProgress | 0 !== this.progress | 0) && (element.children[0].setAttribute("data-progress-text", (0 | this.progress) + "%"), 100 <= this.progress ? t = "99" : (t = this.progress < 10 ? "0" : "", t = t + (0 | this.progress)), element.children[0].setAttribute("data-progress", "" + t)), Pace.trigger("change", this.progress), this.lastRenderedProgress = this.progress;
         };
         Bar.prototype.done = function() {
           return 100 <= this.progress;
         };
         ProgressBar = Bar;
         module.prototype.trigger = function(name, data) {
           var v;
           var _j;
           var _ref;
           var _ref2;
           var _results;
           if (null != this.bindings[name]) {
             _results = [];
             _j = 0;
             _ref = (_ref2 = this.bindings[name]).length;
             for (; _j < _ref; _j++) {
               v = _ref2[_j];
               _results.push(v.call(this, data));
             }
             return _results;
           }
         };
         module.prototype.on = function(event, data) {
           var _base;
           return null == (_base = this.bindings)[event] && (_base[event] = []), this.bindings[event].push(data);
         };
         Module = module;
         _XMLHttpRequest = window.XMLHttpRequest;
         _XDomainRequest = window.XDomainRequest;
         _WebSocket = window.WebSocket;
         extendNative = function main(object, from) {
           var key;
           var _results = [];
           for (key in from.prototype) {
             try {
               if (null == object[key] && "function" != typeof from[key]) {
                 if ("function" == typeof Object.defineProperty) {
                   _results.push(Object.defineProperty(object, key, {
                     get : function(key) {
                       return function() {
                         return from.prototype[key];
                       };
                     }(key),
                     configurable : true,
                     enumerable : true
                   }));
                 } else {
                   _results.push(object[key] = from.prototype[key]);
                 }
               } else {
                 _results.push(void 0);
               }
             } catch (t) {
               0;
             }
           }
           return _results;
         };
         ignoreStack = [];
         Pace.ignore = function() {
           var APIHook = arguments[0];
           var args = 2 <= arguments.length ? slice.call(arguments, 1) : [];
           return ignoreStack.unshift("ignore"), args = APIHook.apply(null, args), ignoreStack.shift(), args;
         };
         Pace.track = function() {
           var APIHook = arguments[0];
           var args = 2 <= arguments.length ? slice.call(arguments, 1) : [];
           return ignoreStack.unshift("track"), args = APIHook.apply(null, args), ignoreStack.shift(), args;
         };
         shouldTrack = function shouldTrack(method) {
           if (null == method && (method = "GET"), "track" === ignoreStack[0]) {
             return "force";
           }
           if (!ignoreStack.length && options.ajax) {
             if ("socket" === method && options.ajax.trackWebSockets) {
               return true;
             }
             if (method = method.toUpperCase(), 0 <= __indexOf.call(options.ajax.trackMethods, method)) {
               return true;
             }
           }
           return false;
         };
         __extends(RequestIntercept, Module);
         Zip = RequestIntercept;
         v = null;
         getSource = function shouldIgnoreURL(url) {
           var i;
           var sortedLanes = options.ajax.ignoreURLs;
           var notI = 0;
           var numberOfToppings = sortedLanes.length;
           for (; notI < numberOfToppings; notI++) {
             if ("string" == typeof(i = sortedLanes[notI])) {
               if (-1 !== url.indexOf(i)) {
                 return true;
               }
             } else {
               if (i.test(url)) {
                 return true;
               }
             }
           }
           return false;
         };
         (getIntercept = function extractPresetLocal() {
           return v = null == v ? new Zip : v;
         })().on("request", function(event) {
           var queueArgs;
           var type = event.type;
           var request = event.request;
           var d = event.url;
           if (!getSource(d)) {
             return Pace.running || false === options.restartOnRequestAfter && "force" !== shouldTrack(type) ? void 0 : (queueArgs = arguments, "boolean" == typeof(d = options.restartOnRequestAfter || 0) && (d = 0), setTimeout(function() {
               var _k;
               var _len2;
               var _ref3;
               var r;
               var _ref2 = "socket" === type ? request.readyState < 1 : 0 < (_ref2 = request.readyState) && _ref2 < 4;
               if (_ref2) {
                 Pace.restart();
                 r = [];
                 _k = 0;
                 _len2 = (_ref3 = Pace.sources).length;
                 for (; _k < _len2; _k++) {
                   if ((source = _ref3[_k]) instanceof ajax) {
                     source.watch.apply(source, queueArgs);
                     break;
                   }
                   r.push(void 0);
                 }
                 return r;
               }
             }, d));
           }
         });
         AjaxMonitor.prototype.watch = function(file) {
           var fileprop = file.type;
           var node = file.request;
           file = file.url;
           if (!getSource(file)) {
             return node = new ("socket" === fileprop ? TimedMoveable : Moveable)(node, this.complete), this.elements.push(node);
           }
         };
         AjaxMonitor.prototype.complete = function(value) {
           return this.elements = this.elements.filter(function(optionsValue) {
             return optionsValue !== value;
           });
         };
         ajax = AjaxMonitor;
         Moveable = function XHRRequestTracker(request, resolve) {
           var idx;
           var tracksDataLen;
           var _onreadystatechange;
           var _ref2;
           var _this = this;
           if (this.progress = 0, null != window.ProgressEvent) {
             cb(request, "progress", function(event) {
               return event.lengthComputable ? _this.progress = 100 * event.loaded / event.total : _this.progress = _this.progress + (100 - _this.progress) / 2;
             });
             idx = 0;
             tracksDataLen = (_ref2 = ["load", "abort", "timeout", "error"]).length;
             for (; idx < tracksDataLen; idx++) {
               cb(request, _ref2[idx], function() {
                 return resolve(_this), _this.progress = 100;
               });
             }
           } else {
             _onreadystatechange = request.onreadystatechange;
             request.onreadystatechange = function() {
               var _ref3;
               return 0 === (_ref3 = request.readyState) || 4 === _ref3 ? (resolve(_this), _this.progress = 100) : 3 === request.readyState && (_this.progress = 50), "function" == typeof _onreadystatechange ? _onreadystatechange.apply(null, arguments) : void 0;
             };
           }
         };
         TimedMoveable = function init(buf, e) {
           var result;
           var B = this;
           var p = this.progress = 0;
           var aOpL = (result = ["error", "open"]).length;
           for (; p < aOpL; p++) {
             cb(buf, result[p], function() {
               return e(B), B.progress = 100;
             });
           }
         };
         Tour.prototype.complete = function(value) {
           return this.elements = this.elements.filter(function(optionsValue) {
             return optionsValue !== value;
           });
         };
         getFromDOM = Tour;
         ElementTracker.prototype.check = function() {
           var PWWWService = this;
           return document.querySelector(this.selector) ? this.done() : setTimeout(function() {
             return PWWWService.check();
           }, options.elements.checkInterval);
         };
         ElementTracker.prototype.done = function() {
           return this.completeCallback(this), this.completeCallback = null, this.progress = 100;
         };
         Model = ElementTracker;
         DocumentMonitor.prototype.states = {
           loading : 0,
           interactive : 50,
           complete : 100
         };
         message = DocumentMonitor;
         __extends = function EventLagMonitor() {
           var avg;
           var initializeCheckTimer;
           var timestamp;
           var points;
           var samples;
           var pubPromise = this;
           this.progress = 0;
           samples = [];
           points = 0;
           timestamp = now();
           initializeCheckTimer = setInterval(function() {
             var avcSample = now() - timestamp - 50;
             return timestamp = now(), samples.push(avcSample), samples.length > options.eventLag.sampleCount && samples.shift(), avg = avgAmplitude(samples), ++points >= options.eventLag.minSamples && avg < options.eventLag.lagThreshold ? (pubPromise.progress = 100, clearInterval(initializeCheckTimer)) : pubPromise.progress = 3 / (avg + 3) * 100;
           }, 50);
         };
         Scaler.prototype.tick = function(frameTime, val) {
           return 100 <= (val = null == val ? result(this.source, "progress") : val) && (this.done = true), val === this.last ? this.sinceLastUpdate += frameTime : (this.sinceLastUpdate && (this.rate = (val - this.last) / this.sinceLastUpdate), this.catchup = (val - this.progress) / options.catchupTime, this.sinceLastUpdate = 0, this.last = val), val > this.progress && (this.progress += this.catchup * frameTime), val = 1 - Math.pow(this.progress / 100, options.easeFactor), this.progress += val * this.rate *
           frameTime, this.progress = Math.min(this.lastProgress + options.maxProgressPerFrame, this.progress), this.progress = Math.max(0, this.progress), this.progress = Math.min(100, this.progress), this.lastProgress = this.progress, this.progress;
         };
         Set = Scaler;
         guard = svg = uniScaler = bar = handle = sources = null;
         Pace.running = false;
         mergePathComponents = function handlePushState() {
           if (options.restartOnPushState) {
             return Pace.restart();
           }
         };
         if (null != window.history.pushState) {
           _pushState = window.history.pushState;
           window.history.pushState = function() {
             return mergePathComponents(), _pushState.apply(window.history, arguments);
           };
         }
         if (null != window.history.replaceState) {
           _replaceState = window.history.replaceState;
           window.history.replaceState = function() {
             return mergePathComponents(), _replaceState.apply(window.history, arguments);
           };
         }
         SOURCE_KEYS = {
           ajax : ajax,
           elements : getFromDOM,
           document : message,
           eventLag : __extends
         };
         (breatheGate = function init() {
           var type;
           var _j;
           var _k;
           var _ref;
           var _len2;
           var _ref2;
           var _ref4;
           var _ref3;
           Pace.sources = sources = [];
           _j = 0;
           _ref = (_ref2 = ["ajax", "elements", "document", "eventLag"]).length;
           for (; _j < _ref; _j++) {
             if (false !== options[type = _ref2[_j]]) {
               sources.push(new SOURCE_KEYS[type](options[type]));
             }
           }
           _k = 0;
           _len2 = (_ref3 = null != (_ref4 = options.extraSources) ? _ref4 : []).length;
           for (; _k < _len2; _k++) {
             source = _ref3[_k];
             sources.push(new source(options));
           }
           return Pace.bar = bar = new ProgressBar, handle = [], uniScaler = new Set;
         })();
         Pace.stop = function() {
           return Pace.trigger("stop"), Pace.running = false, bar.destroy(), guard = true, null != svg && ("function" == typeof transform && transform(svg), svg = null), breatheGate();
         };
         Pace.restart = function() {
           return Pace.trigger("restart"), Pace.stop(), Pace.start();
         };
         Pace.go = function() {
           var start;
           return Pace.running = true, bar.render(), start = now(), guard = false, svg = draw(function(frameTime, slice) {
             bar.progress;
             var avg;
             var elements;
             var x;
             var item;
             var index;
             var sum;
             var i;
             var k;
             var _jlen;
             var _ref2;
             var size = sum = 0;
             var done = true;
             var j = i = 0;
             var length = sources.length;
             for (; i < length; j = ++i) {
               source = sources[j];
               index = null != handle[j] ? handle[j] : handle[j] = [];
               x = k = 0;
               _jlen = (elements = null != (_ref2 = source.elements) ? _ref2 : [source]).length;
               for (; k < _jlen; x = ++k) {
                 item = elements[x];
                 done = done & (item = null != index[x] ? index[x] : index[x] = new Set(item)).done;
                 if (!item.done) {
                   size++;
                   sum = sum + item.tick(frameTime);
                 }
               }
             }
             return avg = sum / size, bar.update(uniScaler.tick(frameTime, avg)), bar.done() || done || guard ? (bar.update(100), Pace.trigger("done"), setTimeout(function() {
               return bar.finish(), Pace.running = false, Pace.trigger("hide");
             }, Math.max(options.ghostTime, Math.max(options.minTime - (now() - start), 0)))) : slice();
           });
         };
         Pace.start = function(_s3Params) {
           extend(options, _s3Params);
           Pace.running = true;
           try {
             bar.render();
           } catch (_error) {
             NoTargetError = _error;
           }
           return document.querySelector(".pace") ? (Pace.trigger("start"), Pace.go()) : setTimeout(Pace.start, 50);
         };
         if ("function" == typeof define && define.amd) {
           define(function() {
             return Pace;
           });
         } else {
           if ("object" == (typeof exports === "undefined" ? "undefined" : _typeof(exports))) {
             module.exports = Pace;
           } else {
             if (options.startOnPageLoad) {
               Pace.start();
             }
           }
         }
        }.call(undefined);
    },

    set_Reemplazar_tema: function(){
        $("#form_reemplazar_tema").validate(
        {
            submitHandler:function(form)
            {
                var lines = $('#vc_reemplazar_tema').val().split('\n');

                $(".Editor-editor .cambiar_tema").each(function (key, data){

                    if ( typeof lines[key] !== 'undefined' && lines[key] !== '' )
                    {
                        var v_id = $(".Editor-editor #" + this.id).attr("data-id");
                        var v_vc_name = $(".Editor-editor #" + this.id).attr("data-name");
                        var v_tipo = $(".Editor-editor #" + this.id).attr("data-tipo");
                        let lines_key= lines[key];
                        lines_key= lines_key.replace('/', '\\/').replace('vc', '').replace('_', '').replace('id', '');
                        lines_key = lines_key.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                            return letter.toUpperCase();
                        });

                        var valDataGrep = "grep -wrl 'v" + v_tipo + v_id + "_" + v_vc_name + "' ./ | xargs sed -i 's/v" + v_tipo + v_id + "_" + v_vc_name + "/" + lines_key + "/g' \n";

                        $(".Editor-editor #" + this.id).attr("data-grep", valDataGrep );
                        $(".Editor-editor #" + this.id).attr("value", lines_key );
                    }
                });

                $(".Editor-editor .cambiar_campo").each(function (key, data){
                    if ( typeof lines[key] !== 'undefined' && lines[key] !== '')
                    {
                        var v_id = $(".Editor-editor #" + this.id).attr("data-id");
                        var v_vc_name = $(".Editor-editor #" + this.id).attr("data-name");
                        var v_tipo = $(".Editor-editor #" + this.id).attr("data-tipo");
                        let lines_key= lines[key];
                        lines_key= lines_key.replace('/', '_');

                        var valDataGrep = "grep -wrl 'v" + v_tipo + v_id + "_" + v_vc_name + "' ./ | xargs sed -i 's/v" + v_tipo + v_id + "_" + v_vc_name + "/" + lines_key + "/g' \n";

                        $(".Editor-editor #" + this.id).attr("data-grep", valDataGrep );
                        $(".Editor-editor #" + this.id).attr("value", lines_key );

                    }
                });

                $("#modal_form_reemplazar_tema .close").click();
            }
            , errorPlacement: function(error, element) {
                error.insertAfter($("#"+element.attr("name")).next("span"));
            }
            , rules: {
                vc_reemplazar_tema: {
                required: true,
            }
          }
        });
    },

    eventos: function() {

        $(document).on("click", "#reset-api", function(){

            $.ajax({
                url:"reset_api",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                    success: function(response)
                    {
                        $('#tb-datatable-api_by_lumic').DataTable().ajax.reload();
                    }
            });

        });

        $('#modal_form_reemplazar_tema').on('hidden.bs.modal', function (e) {
            document.getElementById("vc_reemplazar_tema").value = "";
        });


        $('#modal_form_reemplazar_tema').on('shown.bs.modal', function (e) {
            $('#vc_reemplazar_tema', e.target).focus();
        });

        $('textarea').on('paste', function(event) {
            event.preventDefault();//prevent pasted text being added
            // add ID so we can clear textarea
            let text_area_id = $(this).attr('id');
            $('#' + text_area_id).val('');
            let clip = event.originalEvent.clipboardData.getData('Text');
            let final_clip = clip.replace(/\s+/g, ' ');
            let spacio= final_clip.replaceAll(' ', '\n');

            $('#' + text_area_id).val(spacio);

        });

        $('#seleccionar-todo').click(function() {
            $('input[type="checkbox"]').prop('checked', this.checked)
        });

    }
};

$(function() {
    Api_by_lumic.init();
});