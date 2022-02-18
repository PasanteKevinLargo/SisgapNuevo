(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[8],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/src/components/10Oficio.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/src/components/10Oficio.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_tables_2__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-tables-2 */ "./node_modules/vue-tables-2/compiled/index.js");
/* harmony import */ var vue_tables_2__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue_tables_2__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var vue_select_dist_vue_select_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-select/dist/vue-select.css */ "./node_modules/vue-select/dist/vue-select.css");
/* harmony import */ var vue_select_dist_vue_select_css__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(vue_select_dist_vue_select_css__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var bootstrap_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! bootstrap-vue */ "./node_modules/bootstrap-vue/esm/index.js");
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! vue-multiselect */ "./node_modules/vue-multiselect/dist/vue-multiselect.min.js");
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(vue_multiselect__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var vue_select__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! vue-select */ "./node_modules/vue-select/dist/vue-select.js");
/* harmony import */ var vue_select__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(vue_select__WEBPACK_IMPORTED_MODULE_5__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



vue__WEBPACK_IMPORTED_MODULE_0___default.a.use(vue_tables_2__WEBPACK_IMPORTED_MODULE_1__["ClientTable"]);

vue__WEBPACK_IMPORTED_MODULE_0___default.a.use(bootstrap_vue__WEBPACK_IMPORTED_MODULE_3__["PaginationPlugin"]);


/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'tables-vue-tables-2',
  metaInfo: {
    title: 'Vue Tables 2 - Tables'
  },
  components: {
    Multiselect: vue_multiselect__WEBPACK_IMPORTED_MODULE_4___default.a,
    vSelect: vue_select__WEBPACK_IMPORTED_MODULE_5___default.a
  },
  data: function data() {
    return {
      arrayCliente: [],
      vselectCliente: null,
      buscar: '',
      currentPage: 1,
      modal: 0,
      //modal data
      id_rol: 0,
      id_contrato: 0,
      nombre: '',
      costo_base: 0.00,
      costo_excedente: 0.00,
      num_documentos: 0,
      tipo_contrato: '',
      //1=Fijo 2=calculado
      tipocontrato: 0,
      desde: '',
      hasta: '',
      periodo_mes: 0,
      activo: 1,
      titulomodal1: '',
      arrayRol: [],
      //fin modal data-----
      errorPersona: 0,
      errorMostrarMsjPersona: [],
      //table data
      tableData: [],
      columns: ['CODIGO_PROYECTO', 'DESCRIPCION_PROYECTO', 'NOMBRE_FINANCIADOR', 'ID_PERSONAL', 'COSTO_PROYECTO', 'FECHAINICIO_PROYECTO', 'FECHAFIN_PROYECTO', 'accion'],
      options: {
        filterable: false,
        headings: {
          CODIGO_PROYECTO: 'CÓDIGO',
          DESCRIPCION_PROYECTO: 'NOMBRE DEL PROYECTO',
          NOMBRE_FINANCIADOR: 'FINANCIADOR',
          ID_PERSONAL: 'DIRECTOR',
          COSTO_PROYECTO: 'MONTO',
          FECHAINICIO_PROYECTO: 'FECHA INICIO',
          FECHAFIN_PROYECTO: 'FECHA FIN'
        },
        templates: {
          ID_PERSONAL: function ID_PERSONAL(h, row) {
            return row.NOMBRES_PERSONAL + ' ' + row.APELLIDOS_PERSONAL;
          },
          tipo_contrato: function tipo_contrato(h, row) {
            if (row.tipo_contrato == 1) {
              return "Fijo";
            } else if (row.tipo_contrato == 2) {
              return "Calculado";
            }
          },
          sis_activo: function sis_activo(h, row) {
            switch (row.sis_activo) {
              case 0:
                return 'Inactivo';
                break;

              case 1:
                return 'Activo';
                break;

              case 2:
                return 'Deudor';
                break;

              case 3:
                return 'Suspendido';
                break;

              default:
                break;
            }
          }
        }
      },
      paginacion: {
        'total': 0,
        'current_page': 0,
        'per_page': 0,
        'last_page': 0,
        'from': 0,
        'to': 0
      } //fin table data------

    };
  },
  created: function created() {// Fetch json data
  },
  computed: {
    isActived: function isActived() {
      return this.paginacion.current_page;
    },
    pagesNumber: function pagesNumber() {
      if (!this.paginacion.to) {
        return [];
      }

      var from = this.paginacion.current_page - this.offset;

      if (from < 1) {
        from = 1;
      }

      var to = from + this.offset * 2;

      if (to >= this.paginacion.last_page) {
        to = this.paginacion.last_page;
      }

      var pagesArray = [];

      while (from <= to) {
        pagesArray.push(from);
        from++;
      }

      return pagesArray;
    }
  },
  methods: {
    cambiarPagina: function cambiarPagina(page, buscar) {
      var me = this; //actualiza la pag actual

      me.pagination.current_page = page;
      me.ListarOficios(page, buscar);
    },
    pageChange: function pageChange(page) {
      this.currentPage = page;
      this.ListarOficios(page, ''); // api call
    },
    msjform: function msjform(header, text, variant) {
      this.$bvToast.toast("".concat(text), {
        title: "".concat(header),
        autoHideDelay: 3000,
        appendToast: true,
        toastClass: variant ? "bs4-toast bg-".concat(variant) : 'bs4-toast'
      });
    },
    metodocancelar: function metodocancelar() {//this.nombre="metodo cancelar";
    },
    selectCliente: function selectCliente(search, loading) {
      var me = this;
      loading(true);
      var url = '/user/selectUser?filtro=' + search;
      axios.get(url).then(function (response) {
        var respuesta = response.data;

        q: search;

        me.arrayCliente = respuesta.clientes;
        loading(false);
      })["catch"](function (error) {
        // handle error
        console.log(error);
      });
    },
    metodook: function metodook(bvModalEvt) {
      bvModalEvt.preventDefault();
      this.registrarContrato();
    },
    selectRol: function selectRol() {
      var me = this;
      var url = '/rol/selectRol';
      axios.get(url).then(function (response) {
        var respuesta = response.data;
        me.arrayRol = respuesta.roles;
      })["catch"](function (error) {
        console.log(error);
      });
    },
    ListarOficios: function ListarOficios(page, buscar) {
      var me = this;
      var url = '/proyecto?page=' + page + '&buscar=' + buscar;
      axios.get(url).then(function (response) {
        var respuesta = response.data;
        me.tableData = respuesta.proyectos.data;
        me.paginacion = respuesta.pagination; // handle success
        //console.log(response);
        // me.arrayBanco = response.data;
      })["catch"](function (error) {
        // handle error
        console.log(error);
      });
    },
    registrarContrato: function registrarContrato() {
      // if (this.validarContrato()){
      //     return;
      // }
      switch (this.tipo_contrato) {
        case 'Fijo':
          this.tipocontrato = 1;
          break;

        case 'Calculado':
          this.tipocontrato = 2;
          break;

        default:
          break;
      }

      var me = this;

      if (this.tituloaccion == "Guardar") {
        axios.post('/contrato/registrar', {
          'id_cliente': this.vselectCliente.id,
          'tipo_contrato': this.tipocontrato,
          'num_documentos': this.num_documentos,
          'desde': this.desde,
          'hasta': this.hasta,
          'costo_base': this.costo_base,
          'costo_excedente': this.costo_excedente,
          'periodo_mes': this.periodo_mes,
          'activo': this.activo
        }).then(function (response) {
          me.ListarOficios(1, '');
          me.msjform('Correcto', 'Grabado exitosamente', 'success');
          me.$nextTick(function () {
            me.$bvModal.hide('modal-1');
          });
        })["catch"](function (error) {
          // handle error
          console.log(error);
          me.msjform('Usuario ya existe', 'No se ha registrado', 'danger');
        });
      } else if (this.tituloaccion == "Actualizar") {
        axios.put('/contrato/actualizar', {
          'id': this.id_contrato,
          'id_cliente': this.vselectCliente.id,
          'tipo_contrato': this.tipocontrato,
          'num_documentos': this.num_documentos,
          'desde': this.desde,
          'hasta': this.hasta,
          'costo_base': this.costo_base,
          'costo_excedente': this.costo_excedente,
          'periodo_mes': this.periodo_mes,
          'activo': this.activo
        }).then(function (response) {
          me.ListarOficios(1, '');
          me.msjform('Correcto', 'Actualizado exitosamente', 'success');
          me.$nextTick(function () {
            me.$bvModal.hide('modal-1');
          });
        })["catch"](function (error) {
          // handle error
          console.log(error);
          me.msjform('Error', 'No se pudo actualizar', 'danger');
        });
      }
    },
    validarContrato: function validarContrato() {
      this.errorPersona = 0;
      this.errorMostrarMsjPersona = [];
      if (!this.nombre) this.errorMostrarMsjPersona.push("El nombre de la persona no puede estar vacío.");
      if (!this.usuario) this.errorMostrarMsjPersona.push("Ingrese Identificación");
      if (!this.password) this.errorMostrarMsjPersona.push("El password no puede estar vacío.");
      if (this.tipo_dni == 0) this.errorMostrarMsjPersona.push("Elija tipo de Identificación");
      if (this.id_rol == 0) this.errorMostrarMsjPersona.push("Debes seleccionar un rol para el usuario.");
      if (!this.email) this.errorMostrarMsjPersona.push("Ingrese Correo");
      if (this.errorMostrarMsjPersona.length) this.errorPersona = 1;
      return this.errorPersona;
    },
    showModal: function showModal(accion, row) {
      this.$refs['modal-1'].show();

      switch (accion) {
        case 1:
          this.titulomodal1 = 'Nuevo';
          this.tituloaccion = 'Guardar';
          this.borrarFormulario();
          break;

        case 2:
          this.titulomodal1 = 'Actualizar';
          this.tituloaccion = 'Actualizar';
          this.id_contrato = row.id;
          this.tipo_contrato = row.tipo_contrato;

          if (row.tipo_contrato == 1) {
            this.tipo_contrato = 'Fijo';
          } else if (row.tipo_contrato == 2) {
            this.tipo_contrato = 'Calculado';
          }

          this.num_documentos = row.num_documentos;
          this.desde = row.desde;
          this.hasta = row.hasta;
          this.costo_base = row.costo_base;
          this.costo_excedente = row.costo_excedente;
          this.periodo_mes = row.periodo_mes;
          this.activo = row.activo;
          this.vselectCliente = {
            id: row.id,
            nombre: row.nombre
          };
          break;
      }
    },
    borrarFormulario: function borrarFormulario() {
      this.vselectCliente = null;
      this.tipocontrato = '';
      this.num_documentos = 0;
      this.desde = '';
      this.hasta = '';
      this.costo_base = 0.00;
      this.costo_excedente = 0.00;
      this.periodo_mes = 0;
      this.activo = 1;
    }
  },
  mounted: function mounted() {
    this.ListarOficios(1, ''); //this.selectRol();
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/src/components/10Oficio.vue?vue&type=template&id=7760d670&":
/*!*******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/src/components/10Oficio.vue?vue&type=template&id=7760d670& ***!
  \*******************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("h4", { staticClass: "font-weight-bold py-3 mb-4" }, [
        _c("span", { staticClass: "text-muted font-weight-light" }, [
          _vm._v("Trámites /")
        ]),
        _vm._v(" Oficios\n    "),
        _c(
          "button",
          {
            staticClass: "btn btn-sm btn-success",
            attrs: { type: "button" },
            on: {
              click: function($event) {
                return _vm.showModal(1)
              }
            }
          },
          [_c("span", { staticClass: "ion ion-md-add-circle-outline" })]
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "form-group row" }, [
        _c("div", { staticClass: "col-md-5" }, [
          _c("div", { staticClass: "input-group" }, [
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.buscar,
                  expression: "buscar"
                }
              ],
              staticClass: "form-control",
              attrs: { type: "text", placeholder: "Texto a buscar" },
              domProps: { value: _vm.buscar },
              on: {
                keyup: function($event) {
                  if (
                    !$event.type.indexOf("key") &&
                    _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")
                  ) {
                    return null
                  }
                  return _vm.ListarOficios(1, _vm.buscar)
                },
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.buscar = $event.target.value
                }
              }
            }),
            _vm._v(" "),
            _c(
              "button",
              {
                staticClass: "btn btn-primary",
                attrs: { type: "submit" },
                on: {
                  click: function($event) {
                    return _vm.ListarOficios(1, _vm.buscar)
                  }
                }
              },
              [_c("i", { staticClass: "fa fa-search" }), _vm._v(" Buscar")]
            )
          ])
        ])
      ]),
      _vm._v(" "),
      _c("hr", { staticClass: "container-m-nx border-light mt-0 mb-5" }),
      _vm._v(" "),
      _c("v-client-table", {
        attrs: {
          data: _vm.tableData,
          columns: _vm.columns,
          options: _vm.options
        },
        scopedSlots: _vm._u([
          {
            key: "accion",
            fn: function(props) {
              return [
                _c(
                  "div",
                  [
                    _c(
                      "b-btn",
                      {
                        staticClass: "btn-xs",
                        attrs: {
                          variant: "outline-warning borderless icon-btn"
                        },
                        on: {
                          click: function($event) {
                            return _vm.showModal(2, props.row)
                          }
                        }
                      },
                      [_c("i", { staticClass: "ion ion-md-create" })]
                    )
                  ],
                  1
                )
              ]
            }
          }
        ])
      }),
      _vm._v("\n  Total Documentos: " + _vm._s(_vm.paginacion.total) + "\n  "),
      _c("b-pagination", {
        attrs: {
          size: "lg",
          "total-rows": _vm.paginacion.total,
          "per-page": 10
        },
        on: { change: _vm.pageChange },
        model: {
          value: _vm.currentPage,
          callback: function($$v) {
            _vm.currentPage = $$v
          },
          expression: "currentPage"
        }
      }),
      _vm._v(" "),
      _c(
        "b-card-body",
        [
          _c(
            "b-modal",
            {
              ref: "modal-1",
              attrs: {
                id: "modal-1",
                size: "xl",
                "cancel-title": "Cancelar",
                "ok-title": "Guardar"
              },
              on: {
                cancel: function($event) {
                  return _vm.metodocancelar()
                },
                ok: _vm.metodook
              }
            },
            [
              _c(
                "div",
                { attrs: { slot: "modal-title" }, slot: "modal-title" },
                [
                  _vm._v("\n          " + _vm._s(_vm.titulomodal1) + " "),
                  _c("span", { staticClass: "font-weight-light" }, [
                    _vm._v("Proyecto")
                  ]),
                  _vm._v(" "),
                  _c(
                    "b-btn",
                    {
                      staticClass: "btn-sm",
                      attrs: { variant: "outline-warning borderless icon-btn" },
                      on: {
                        click: function($event) {
                          return _vm.showModal(2, _vm.props.row)
                        }
                      }
                    },
                    [_c("i", { staticClass: "ion ion-md-create" })]
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "b-form-row",
                [
                  _c(
                    "b-form-group",
                    { staticClass: "col-3", attrs: { label: "Código PUCE" } },
                    [
                      [
                        _c("b-form-input", {
                          attrs: {
                            list: "tipo-contrato",
                            placeholder: "Enter Price"
                          },
                          model: {
                            value: _vm.tipo_contrato,
                            callback: function($$v) {
                              _vm.tipo_contrato = $$v
                            },
                            expression: "tipo_contrato"
                          }
                        })
                      ]
                    ],
                    2
                  ),
                  _vm._v(" "),
                  _c(
                    "b-form-group",
                    {
                      staticClass: "col-9",
                      attrs: { label: "Nombre del Proyecto" }
                    },
                    [
                      _c("b-input", {
                        attrs: { placeholder: "" },
                        model: {
                          value: _vm.num_documentos,
                          callback: function($$v) {
                            _vm.num_documentos = $$v
                          },
                          expression: "num_documentos"
                        }
                      })
                    ],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "b-form-row",
                [
                  _c(
                    "b-form-group",
                    { staticClass: "col-2", attrs: { label: "Fecha Inicio" } },
                    [
                      _c("b-input", {
                        attrs: { placeholder: "" },
                        model: {
                          value: _vm.num_documentos,
                          callback: function($$v) {
                            _vm.num_documentos = $$v
                          },
                          expression: "num_documentos"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "b-form-group",
                    {
                      staticClass: "col-2",
                      attrs: { label: "Fecha Finalización" }
                    },
                    [
                      _c("b-input", {
                        attrs: { placeholder: "" },
                        model: {
                          value: _vm.num_documentos,
                          callback: function($$v) {
                            _vm.num_documentos = $$v
                          },
                          expression: "num_documentos"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "b-form-group",
                    { staticClass: "col-4", attrs: { label: "Financiador" } },
                    [
                      _c("b-input", {
                        attrs: { placeholder: "" },
                        model: {
                          value: _vm.num_documentos,
                          callback: function($$v) {
                            _vm.num_documentos = $$v
                          },
                          expression: "num_documentos"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "b-form-group",
                    { staticClass: "col-4", attrs: { label: "Director" } },
                    [
                      _c("b-input", {
                        attrs: { placeholder: "" },
                        model: {
                          value: _vm.num_documentos,
                          callback: function($$v) {
                            _vm.num_documentos = $$v
                          },
                          expression: "num_documentos"
                        }
                      })
                    ],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "b-form-row",
                [
                  _c(
                    "b-form-group",
                    { staticClass: "col-6", attrs: { label: "Enunciado" } },
                    [
                      [
                        _c("b-form-input", {
                          attrs: {
                            list: "tipo-contrato",
                            placeholder: "Enter Price"
                          },
                          model: {
                            value: _vm.tipo_contrato,
                            callback: function($$v) {
                              _vm.tipo_contrato = $$v
                            },
                            expression: "tipo_contrato"
                          }
                        })
                      ]
                    ],
                    2
                  ),
                  _vm._v(" "),
                  _c(
                    "b-form-group",
                    { staticClass: "col-6", attrs: { label: "Propósito" } },
                    [
                      _c("b-input", {
                        attrs: { placeholder: "" },
                        model: {
                          value: _vm.num_documentos,
                          callback: function($$v) {
                            _vm.num_documentos = $$v
                          },
                          expression: "num_documentos"
                        }
                      })
                    ],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "b-form-row",
                [
                  _c(
                    "b-form-group",
                    {
                      staticClass: "col-3",
                      attrs: { label: "Monto Total Propuesto" }
                    },
                    [
                      _c("b-input", {
                        attrs: { placeholder: "" },
                        model: {
                          value: _vm.num_documentos,
                          callback: function($$v) {
                            _vm.num_documentos = $$v
                          },
                          expression: "num_documentos"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "b-form-group",
                    { staticClass: "col-3", attrs: { label: "Estado" } },
                    [
                      _c("b-input", {
                        attrs: { placeholder: "" },
                        model: {
                          value: _vm.num_documentos,
                          callback: function($$v) {
                            _vm.num_documentos = $$v
                          },
                          expression: "num_documentos"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "b-form-group",
                    { staticClass: "col-3", attrs: { label: "Adjunto 1" } },
                    [
                      _c("b-input", {
                        attrs: { placeholder: "" },
                        model: {
                          value: _vm.num_documentos,
                          callback: function($$v) {
                            _vm.num_documentos = $$v
                          },
                          expression: "num_documentos"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "b-form-group",
                    { staticClass: "col-3", attrs: { label: "Adjunto 2" } },
                    [
                      _c("b-input", {
                        attrs: { placeholder: "" },
                        model: {
                          value: _vm.num_documentos,
                          callback: function($$v) {
                            _vm.num_documentos = $$v
                          },
                          expression: "num_documentos"
                        }
                      })
                    ],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "div",
                {
                  directives: [
                    {
                      name: "show",
                      rawName: "v-show",
                      value: _vm.errorPersona,
                      expression: "errorPersona"
                    }
                  ],
                  staticClass: "form-group row div-error"
                },
                [
                  _c(
                    "div",
                    { staticClass: "text-center text-error" },
                    _vm._l(_vm.errorMostrarMsjPersona, function(error) {
                      return _c("div", {
                        key: error,
                        domProps: { textContent: _vm._s(error) }
                      })
                    }),
                    0
                  )
                ]
              )
            ],
            1
          )
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/assets/src/components/10Oficio.vue":
/*!******************************************************!*\
  !*** ./resources/assets/src/components/10Oficio.vue ***!
  \******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _10Oficio_vue_vue_type_template_id_7760d670___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./10Oficio.vue?vue&type=template&id=7760d670& */ "./resources/assets/src/components/10Oficio.vue?vue&type=template&id=7760d670&");
/* harmony import */ var _10Oficio_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./10Oficio.vue?vue&type=script&lang=js& */ "./resources/assets/src/components/10Oficio.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _vendor_libs_vue_data_tables_vue_data_tables_scss_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @/vendor/libs/vue-data-tables/vue-data-tables.scss?vue&type=style&index=0&lang=scss& */ "./resources/assets/src/vendor/libs/vue-data-tables/vue-data-tables.scss?vue&type=style&index=0&lang=scss&");
/* harmony import */ var vue_multiselect_dist_vue_multiselect_min_css_vue_type_style_index_1_lang_css___WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! vue-multiselect/dist/vue-multiselect.min.css?vue&type=style&index=1&lang=css& */ "./node_modules/vue-multiselect/dist/vue-multiselect.min.css?vue&type=style&index=1&lang=css&");
/* harmony import */ var _vendor_libs_vue_multiselect_vue_multiselect_scss_vue_type_style_index_2_lang_scss___WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @/vendor/libs/vue-multiselect/vue-multiselect.scss?vue&type=style&index=2&lang=scss& */ "./resources/assets/src/vendor/libs/vue-multiselect/vue-multiselect.scss?vue&type=style&index=2&lang=scss&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");








/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_5__["default"])(
  _10Oficio_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _10Oficio_vue_vue_type_template_id_7760d670___WEBPACK_IMPORTED_MODULE_0__["render"],
  _10Oficio_vue_vue_type_template_id_7760d670___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/assets/src/components/10Oficio.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/assets/src/components/10Oficio.vue?vue&type=script&lang=js&":
/*!*******************************************************************************!*\
  !*** ./resources/assets/src/components/10Oficio.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_10Oficio_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./10Oficio.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/src/components/10Oficio.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_10Oficio_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/assets/src/components/10Oficio.vue?vue&type=template&id=7760d670&":
/*!*************************************************************************************!*\
  !*** ./resources/assets/src/components/10Oficio.vue?vue&type=template&id=7760d670& ***!
  \*************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_10Oficio_vue_vue_type_template_id_7760d670___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./10Oficio.vue?vue&type=template&id=7760d670& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/src/components/10Oficio.vue?vue&type=template&id=7760d670&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_10Oficio_vue_vue_type_template_id_7760d670___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_10Oficio_vue_vue_type_template_id_7760d670___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);