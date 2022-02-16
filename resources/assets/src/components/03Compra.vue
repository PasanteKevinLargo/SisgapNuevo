<template>
  <div>
    <h4 class="font-weight-bold py-3 mb-4">
      <span class="text-muted font-weight-light">Proyectos /</span> Compras
    </h4>
    <div class="form-group row">
      <div class="col-md-12">
        <div class="input-group">
          <input
            type="text"
            v-model="buscar"
            @keyup.enter="ListarProyectos(1, buscar)"
            class="form-control col-md-4"
            placeholder="Código / Proyecto / Financiador"
          />
          <button
            type="submit"
            @click="ListarProyectos(1, buscar)"
            class="btn btn-primary"
          >
            <i class="fa fa-search"></i> Buscar
          </button>
        </div>
      </div>
    </div>
    <hr class="container-m-nx border-light mt-0 mb-5" />
    <div class="row">
      <div class="col-md-4 col-lg-4 col-xl-4">
        <v-client-table :data="tableData" :columns="columns" :options="options">
          <template slot="accion" slot-scope="props">
            <div>
              <b-btn
                variant="outline-primary borderless icon-btn"
                class="btn-m"
                @click="ListarCompras(props.row.ID_PROYECTO, 1)"
                ><i class="ion ion-md-eye"></i
              ></b-btn>
            </div>
          </template>
        </v-client-table>
        Total Documentos: {{ paginacion.total }}
        <b-pagination
          size="lg"
          :total-rows="paginacion.total"
          v-model="currentPage"
          :per-page="10"
          @change="pageChange"
        />
      </div>
      <div class="col-md-8 col-lg-8 col-xl-8">
        <!-- Contratos -->
        <b-card no-body class="mb-4" v-if="ID_PROYECTO > 0">
          <b-card-header header-tag="h6"
            >TRANSACCIONES
            <button
              type="button"
              class="btn btn-sm btn-success"
              @click="newCompra()"
            >
              <span class="ion ion-md-add-circle-outline"></span>
            </button>
          </b-card-header>
          <b-card-body>
            <v-client-table
              :data="tableDataCompras"
              :columns="columnsCompras"
              :options="optionsCompras"
            >
              <template slot="accion" slot-scope="props">
                <div>
                  <b-btn
                    variant="outline-primary borderless icon-btn"
                    class="btn-m"
                    @click="
                      showModal(props.row.ID_TRASTOCK, 'modal-gasto')
                    "
                    ><i class="ion ion-md-eye"></i
                  ></b-btn>
                </div>
              </template>
            </v-client-table>
          </b-card-body>
          Total Documentos: {{ paginacionCompras.total }}
          <b-pagination
            size="lg"
            :total-rows="paginacionCompras.total"
            v-model="currentPageContrato"
            :per-page="5"
            @change="pageChangeContrato"
          />
        </b-card>
        <!-- / Contratos -->
      </div>
    </div>
    <!-- Detalle -->
    <b-card no-body class="mb-4">
      <b-card-header header-tag="h6"
        >DETALLE
        <button
          type="button"
          class="btn btn-sm btn-success"
          @click="registrarContrato()"
        >
          {{ tituloaccion }}
        </button>
      </b-card-header>
      <b-card-body>
        <b-tabs class="nav-tabs-top mb-4">
          <b-tab title="DATOS GENERALES" active>
            <div class="card-body">
              <b-form-row>
                <b-form-group label="Proveedor" class="col-5">
                  <v-select
                    @search="selectPersonal"
                    label="NOMBRE"
                    :options="arrayPersonal"
                    placeholder="Buscar Nombre"
                    v-model="vselectPersonal"
                    :disabled="disablededit"
                  >
                  </v-select>
                </b-form-group>
                <b-form-group label="Responsable" class="col-4">
                  <v-select
                    @search="selectPersonal"
                    label="NOMBRE"
                    :options="arrayPersonal"
                    placeholder="Buscar Nombre"
                    v-model="vselectPersonal"
                    :disabled="disablededit"
                  >
                  </v-select>
                </b-form-group>
                <b-form-group label="Cuenta" class="col-3">
                  <v-select
                    @search="selectPersonal"
                    label="NOMBRE"
                    :options="arrayPersonal"
                    placeholder="Buscar Nombre"
                    v-model="vselectPersonal"
                    :disabled="disablededit"
                  >
                  </v-select>
                </b-form-group>
              </b-form-row>
              <b-form-row>
                <b-form-group label="Fecha" class="col-3">
                  <b-input
                    type="date"
                    v-model="FECHAINICIO_CONTRATACIONES"
                    placeholder="mm/dd/aaaa"
                    :disabled="disablededit"
                    :state="stateFechaInicio"
                  />
                </b-form-group>
                <b-form-group label="Fecha Vencimiento" class="col-3">
                  <b-input
                    type="date"
                    v-model="FECHAFIN_CONTRATACIONES"
                    placeholder="mm/dd/aaaa"
                    :disabled="disablededit"
                  />
                </b-form-group>
                <b-form-group label="# Documento" class="col-6">
                  <b-input
                    v-model="OBSERVACIONES_CONTRATACIONES"
                    placeholder="Cargo"
                    :disabled="disablededit"
                  />
                </b-form-group>
              </b-form-row>
            </div>
          </b-tab>
          <b-tab title="VALORES">
            <div class="row">
              <div class="col-md-12 col-lg-12 col-xl-12">
                <b-card no-body class="mb-4 mt-4">
                  <b-card-body>
                    <b-form-row>
                      <b-form-group label="Tarifa Imponible" class="col-3">
                        <b-input
                          v-model="TOTAL_CONTRATACIONES"
                          placeholder="Total"
                          :disabled="disablededit"
                        />
                      </b-form-group>
                      <b-form-group label="Tarifa 0%" class="col-3">
                        <b-input
                          v-model="TOTAL_CONTRATACIONES"
                          placeholder="Total"
                          :disabled="disablededit"
                        />
                      </b-form-group>
                      <b-form-group label="Otros / 10% Servicios" class="col-3">
                        <b-input
                          v-model="TOTAL_CONTRATACIONES"
                          placeholder="Total"
                          :disabled="disablededit"
                        />
                      </b-form-group>
                      <b-form-group label="Subtotal sin IVA" class="col-3">
                        <b-input
                          v-model="TOTAL_CONTRATACIONES"
                          placeholder="Total"
                          :disabled="disablededit"
                        />
                      </b-form-group>
                    </b-form-row>
                    <b-form-row>
                      <b-form-group label="IVA" class="col-3">
                        <b-input
                          v-model="MENSUAL_CONTRATACIONES"
                          placeholder="Mensual"
                          :disabled="disablededit"
                        />
                      </b-form-group>
                      <b-form-group label="Retención Renta" class="col-3">
                        <b-input
                          v-model="MENSUAL_CONTRATACIONES"
                          placeholder="Mensual"
                          :disabled="disablededit"
                        />
                      </b-form-group>
                      <b-form-group label="Retención IVA" class="col-3">
                        <b-input
                          v-model="MENSUAL_CONTRATACIONES"
                          placeholder="Mensual"
                          :disabled="disablededit"
                        />
                      </b-form-group>
                      <b-form-group label="Neto a Pagar" class="col-3">
                        <b-input
                          v-model="MENSUAL_CONTRATACIONES"
                          placeholder="Mensual"
                          :disabled="disablededit"
                        />
                      </b-form-group>
                    </b-form-row>
                  </b-card-body>
                </b-card>
              </div>
            </div>
          </b-tab>
        </b-tabs>

        <!-- Inicio modal Presupuesto -->
        <b-modal
          ref="modal-presupuesto"
          id="modal-presupuesto"
          size="m"
          cancel-title="Cancelar"
          ok-title="Guardar"
          @cancel="metodocancelar(2)"
          @ok="savePresupuesto"
        >
          <div slot="modal-title">
            {{ titulomodal1 }}
            <span class="font-weight-light">Presupuesto</span>
          </div>
          <b-form-row>
            <b-form-group label="Cuenta Contable" class="col-12">
              <v-select
                @search="selectPlan"
                label="TAG_PLAN"
                :options="arrayPlan"
                placeholder="Buscar Nombre"
                v-model="vselectPlan"
                :disabled="disablededit"
              >
              </v-select>
            </b-form-group>
          </b-form-row>
          <b-form-row>
            <b-form-group label="Valor" class="col-12">
              <b-input v-model="valor_Presupuesto" placeholder="####.##" />
            </b-form-group>
          </b-form-row>
          <div v-show="errorPersona" class="form-group row div-error">
            <div class="text-center text-error">
              <div
                v-for="error in errorMostrarMsjPersona"
                :key="error"
                v-text="error"
              ></div>
            </div>
          </div>
        </b-modal>
        <!-- fin modal Presupuesto -->

        <!-- Inicio modal Funciones -->
        <b-modal
          ref="modal-funcion"
          id="modal-funcion"
          size="m"
          cancel-title="Cancelar"
          ok-title="Guardar"
          @cancel="metodocancelar(2)"
          @ok="saveFuncion"
        >
          <div slot="modal-title">
            {{ titulomodal1 }}
            <span class="font-weight-light">Funciones</span>
          </div>
          <b-form-row>
            <b-form-group label="Detalle" class="col-12">
              <b-input v-model="funcion_texto" placeholder="Función" />
            </b-form-group>
          </b-form-row>
        </b-modal>
        <!-- fin modal Funciones -->

        <!-- Inicio modal Productos -->
        <b-modal
          ref="modal-producto"
          id="modal-producto"
          size="m"
          cancel-title="Cancelar"
          ok-title="Guardar"
          @cancel="metodocancelar(2)"
          @ok="saveProducto"
        >
          <div slot="modal-title">
            {{ titulomodal1 }}
            <span class="font-weight-light">Productos</span>
          </div>
          <b-form-row>
            <b-form-group label="Detalle" class="col-12">
              <b-input v-model="producto_texto" placeholder="Producto" />
            </b-form-group>
          </b-form-row>
        </b-modal>
        <!-- fin modal Productos -->
      </b-card-body>
    </b-card>
    <!-- / Detalle -->
  </div>
</template>

<style src="@/vendor/libs/vue-data-tables/vue-data-tables.scss" lang="scss"></style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style src="@/vendor/libs/vue-multiselect/vue-multiselect.scss" lang="scss"></style>


<script>
import Vue from "vue";
import { ClientTable } from "vue-tables-2";
import "vue-select/dist/vue-select.css";

Vue.use(ClientTable);
import { PaginationPlugin } from "bootstrap-vue";
Vue.use(PaginationPlugin);

import Multiselect from "vue-multiselect";

import vSelect from "vue-select";

export default {
  name: "tables-vue-tables-2",
  metaInfo: {
    title: "Vue Tables 2 - Tables",
  },
  components: {
    Multiselect,
    vSelect,
  },
  data: () => ({
    arrayCliente: [],
    arrayPersonal: [],
    arrayPresupuesto: [],
    arrayFuncion: [],
    arrayProducto: [],
    arrayPlan: [],
    arrayComentario: [],
    vselectCliente: null,
    vselectPersonal: null,
    vselectPlan: null,
    buscar: "",
    funcion_texto: "",
    comentario: "",
    currentPage: 1,
    currentPageContrato: 1,
    modal: 0,
    verdetalle: 0,
    nuevodetalle: 0,
    //modal data
    id_rol: 0,
    id_contrato: 0,
    nombre: "",
    ID_PROYECTO: 0,
    ID_CONTRATACIONES: 0,
    ID_PERSONAL: 0,
    CODE_PLAN: "",
    TIPO_CONTRATO: "",
    FECHAINICIO_CONTRATACIONES: "",
    FECHAFIN_CONTRATACIONES: "",
    MENSUAL_CONTRATACIONES: "",
    ESTADO_CONTRATACIONES: "",
    TOTAL_CONTRATACIONES: "",
    OBSERVACIONES_CONTRATACIONES: "",
    valor_Presupuesto: 0.0,
    costo_excedente: 0.0,
    num_documentos: 0,
    tipo_contrato: "", //1=Fijo 2=calculado
    tipocontrato: 0,
    desde: "",
    hasta: "",
    periodo_mes: 0,
    activo: 1,
    titulomodal1: "",
    tituloaccion: "",
    arrayRol: [],
    //fin modal data-----
    errorPersona: 0,
    errorMostrarMsjPersona: [],
    //table data
    tableData: [],
    tableDataCompras: [],
    columns: ["CODIGO_PROYECTO", "DESCRIPCION_PROYECTO", "accion"],
    columnsCompras: [
      "ID_TRASTOCK",
      "ID_JUSTIFICATIONES",
      "NOMBRE_PROVEEDOR",
      "AUTORIZACION_TRASTOCK",
      "SUBTOTAL_TRASTOCK",
      "FECHA_TRASTOCK",
      "ACCION",
    ],
    options: {
      filterable: false,
      headings: {
        CODIGO_PROYECTO: "CÓDIGO",
        DESCRIPCION_PROYECTO: "NOMBRE DEL PROYECTO",
        accion: "ACCIÓN",
      },
      templates: {
        ID_PERSONAL(h, row) {
          return row.NOMBRES_PERSONAL + " " + row.APELLIDOS_PERSONAL;
        },
        tipo_contrato(h, row) {
          if (row.tipo_contrato == 1) {
            return "Fijo";
          } else if (row.tipo_contrato == 2) {
            return "Calculado";
          }
        },
        sis_activo(h, row) {
          switch (row.sis_activo) {
            case 0:
              return "Inactivo";
              break;
            case 1:
              return "Activo";
              break;
            case 2:
              return "Deudor";
              break;
            case 3:
              return "Suspendido";
              break;

            default:
              break;
          }
        },
      },
    },

    optionsCompras: {
      filterable: false,
      headings: {
        ID_TRASTOCK: "#",
        ID_JUSTIFICATIONES: "JUSTIFICACIÓN",
        NOMBRE_PROVEEDOR: "PROVEEDOR",
        AUTORIZACION_TRASTOCK: "# DOCUMENTO",
        SUBTOTAL_TRASTOCK: "SUBTOTAL",
        FECHA_TRASTOCK: "FECHA DE EMISIÓN",
        ACCION: "ACCIÓN",
      },
      templates: {
        NOMBRES_PERSONAL(h, row) {
          return row.NOMBRES_PERSONAL + " " + row.APELLIDOS_PERSONAL;
        },
      },
    },
    paginacion: {
      total: 0,
      current_page: 0,
      per_page: 0,
      last_page: 0,
      from: 0,
      to: 0,
    },
    paginacionCompras: {
      total: 0,
      current_page: 0,
      per_page: 0,
      last_page: 0,
      from: 0,
      to: 0,
    },
    //fin table data------
  }),
  created() {
    // Fetch json data
  },
  computed: {
    isActived: function () {
      return this.paginacion.current_page;
    },
    pagesNumber: function () {
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
    },
  },
  methods: {
    cambiarPagina(page, buscar) {
      let me = this;
      //actualiza la pag actual
      me.pagination.current_page = page;
      me.ListarProyectos(page, buscar);
    },
    pageChange(page) {
      this.currentPage = page;
      this.ListarProyectos(page, ""); // api call
    },

    pageChangeContrato(page) {
      this.currentPageContrato = page;
      this.ListarCompras("", page); // api call
    },
    msjform(header, text, variant) {
      this.$bvToast.toast(`${text}`, {
        title: `${header}`,
        autoHideDelay: 3000,
        appendToast: true,
        toastClass: variant ? `bs4-toast bg-${variant}` : "bs4-toast",
      });
    },
    metodocancelar() {
      //this.nombre="metodo cancelar";
    },
    newCompra() {
      this.tituloaccion = "Guardar";
      this.verdetalle = 1;
      this.nuevodetalle = 1;
      this.borrarFormulario();
    },
    selectPersonal(search, loading) {
      let me = this;
      loading(true);
      var url = "/personal/selectPersonal?filtro=" + search;
      axios
        .get(url)
        .then(function (response) {
          let respuesta = response.data;
          q: search;
          me.arrayPersonal = respuesta.personales;
          loading(false);
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },
    selectPlan(search, loading) {
      let me = this;
      loading(true);
      var url = "/plan/selectPlan?filtro=" + search;
      axios
        .get(url)
        .then(function (response) {
          let respuesta = response.data;
          q: search;
          me.arrayPlan = respuesta.plan;
          loading(false);
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },
    saveContrato() {
      // if (this.validarPresupuesto()) {
      //   return;
      // }
      this.addContrato();
      this.$refs["modal-contrato"].hide();
    },
    saveFuncion() {
      // if (this.validarPresupuesto()) {
      //   return;
      // }
      this.addFuncion();
      this.$refs["modal-funcion"].hide();
    },
    saveProducto() {
      // if (this.validarPresupuesto()) {
      //   return;
      // }
      this.addProducto();
      this.$refs["modal-funcion"].hide();
    },
    addContrato() {
      let me = this;
      axios
        .post("/presupuesto/registrar", {
          idproyecto: 0,
          idcontrato: this.ID_CONTRATACIONES,
          valor: this.valor_Presupuesto,
          CODE_PLAN: this.vselectPlan.CODE_PLAN,
        })
        .then(function (response) {
          me.listPresupuesto();
          me.msjform("Correcto", "Grabado exitosamente", "success");
        })
        .catch(function (error) {
          // handle error
          console.log(error);
          me.msjform("Participante ya existe", "No se ha registrado", "danger");
        });
    },
    addFuncion() {
      let me = this;
      axios
        .post("/funcion/registrar", {
          id_contrato: this.ID_CONTRATACIONES,
          detalle: this.funcion_texto,
        })
        .then(function (response) {
          me.listFunciones();
          me.msjform("Correcto", "Grabado exitosamente", "success");
        })
        .catch(function (error) {
          // handle error
          console.log(error);
          me.msjform("Participante ya existe", "No se ha registrado", "danger");
        });
    },
    addProducto() {
      let me = this;
      axios
        .post("/producto/registrar", {
          id_contrato: this.ID_CONTRATACIONES,
          detalle: this.producto_texto,
        })
        .then(function (response) {
          me.listProductos();
          me.msjform("Correcto", "Grabado exitosamente", "success");
        })
        .catch(function (error) {
          // handle error
          console.log(error);
          me.msjform("Participante ya existe", "No se ha registrado", "danger");
        });
    },
    addComentario() {
      let me = this;
      axios
        .post("/comentario/registrar", {
          idproyecto: 0,
          idcontrato: this.ID_CONTRATACIONES,
          comentario: this.comentario,
        })
        .then(function (response) {
          me.listComentarios();
          me.comentario = "";
          me.msjform("Correcto", "Grabado exitosamente", "success");
        })
        .catch(function (error) {
          // handle error
          console.log(error);
          me.msjform(
            "No se agregó comentarios",
            "No se ha registrado",
            "danger"
          );
        });
    },
    metodook(bvModalEvt) {
      bvModalEvt.preventDefault();
      this.registrarContrato();
    },
    selectRol() {
      let me = this;
      var url = "/rol/selectRol";
      axios
        .get(url)
        .then(function (response) {
          var respuesta = response.data;
          me.arrayRol = respuesta.roles;
        })
        .catch(function (error) {
          console.log(error);
        });
    },

    listPresupuesto() {
      let me = this;
      var url =
        "/presupuesto/index?buscar=" +
        this.ID_PROYECTO +
        "&idcontrato=" +
        this.ID_CONTRATACIONES;
      axios
        .get(url)
        .then(function (response) {
          console.log(response);
          var respuesta = response.data;
          me.arrayPresupuesto = respuesta.presupuestos;
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },

    listFunciones() {
      let me = this;
      var url = "/funcion/index?buscar=" + this.ID_CONTRATACIONES;
      axios
        .get(url)
        .then(function (response) {
          console.log(response);
          var respuesta = response.data;
          me.arrayFuncion = respuesta.registros;
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },

    listProductos() {
      let me = this;
      var url = "/producto/index?buscar=" + this.ID_CONTRATACIONES;
      axios
        .get(url)
        .then(function (response) {
          console.log(response);
          var respuesta = response.data;
          me.arrayProducto = respuesta.registros;
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },

    listComentarios() {
      let me = this;
      var url = "/comentario/index?tipo=2&id=" + this.ID_CONTRATACIONES;
      axios
        .get(url)
        .then(function (response) {
          console.log(response);
          var respuesta = response.data;
          me.arrayComentario = respuesta.registros;
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },

    ListarProyectos(page, buscar) {
      let me = this;
      var url = "/proyecto?page=" + page + "&buscar=" + buscar + "&paginate=4";
      axios
        .get(url)
        .then(function (response) {
          var respuesta = response.data;
          me.tableData = respuesta.proyectos.data;
          me.paginacion = respuesta.pagination;
          // handle success
          //console.log(response);
          // me.arrayBanco = response.data;
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },
    ListarCompras(row, page) {
      this.ID_PROYECTO = row;
      let me = this;
      var url =
        "/compra/index?page=" + page + "&ID_PROYECTO=" + this.ID_PROYECTO;
      axios
        .get(url)
        .then(function (response) {
          var respuesta = response.data;
          me.tableDataCompras = respuesta.registros.data;
          me.paginacionCompras = respuesta.pagination;
          me.verdetalle = 0;
          // handle success
          //console.log(response);
          // me.arrayBanco = response.data;
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },
    registrarContrato() {
      // if (this.validarContrato()){
      //     return;
      // }
      let me = this;
      if (this.tituloaccion == "Guardar") {
        axios
          .post("/contrato/registrar", {
            ID_PROYECTO: this.ID_PROYECTO,
            ID_PERSONAL: this.vselectPersonal.ID_PERSONAL,
            TIPO_CONTRATO: this.TIPO_CONTRATO,
            ESTADO_CONTRATACIONES: this.ESTADO_CONTRATACIONES,
            FECHAINICIO_CONTRATACIONES: this.FECHAINICIO_CONTRATACIONES,
            FECHAFIN_CONTRATACIONES: this.FECHAFIN_CONTRATACIONES,
            OBSERVACIONES_CONTRATACIONES: this.OBSERVACIONES_CONTRATACIONES,
            TOTAL_CONTRATACIONES: this.TOTAL_CONTRATACIONES,
            MENSUAL_CONTRATACIONES: this.MENSUAL_CONTRATACIONES,
          })
          .then(function (response) {
            me.ListarCompras(me.ID_PROYECTO, 1);
            me.msjform("Correcto", "Grabado exitosamente", "success");
          })
          .catch(function (error) {
            // handle error
            console.log(error);
            me.msjform("Error", "No se ha registrado", "danger");
          });
      } else if (this.tituloaccion == "Actualizar") {
        axios
          .put("/contrato/actualizar", {
            id: this.id_contrato,
            id_cliente: this.vselectCliente.id,
            tipo_contrato: this.tipocontrato,
            num_documentos: this.num_documentos,
            desde: this.desde,
            hasta: this.hasta,
            costo_base: this.costo_base,
            costo_excedente: this.costo_excedente,
            periodo_mes: this.periodo_mes,
            activo: this.activo,
          })
          .then(function (response) {
            me.ListarProyectos(1, "");
            me.msjform("Correcto", "Actualizado exitosamente", "success");
            me.$nextTick(() => {
              me.$bvModal.hide("modal-1");
            });
          })
          .catch(function (error) {
            // handle error
            console.log(error);
            me.msjform("Error", "No se pudo actualizar", "danger");
          });
      }
    },
    validarContrato() {
      this.errorPersona = 0;
      this.errorMostrarMsjPersona = [];

      if (!this.nombre)
        this.errorMostrarMsjPersona.push(
          "El nombre de la persona no puede estar vacío."
        );
      if (!this.usuario)
        this.errorMostrarMsjPersona.push("Ingrese Identificación");
      if (!this.password)
        this.errorMostrarMsjPersona.push("El password no puede estar vacío.");
      if (this.tipo_dni == 0)
        this.errorMostrarMsjPersona.push("Elija tipo de Identificación");
      if (this.id_rol == 0)
        this.errorMostrarMsjPersona.push(
          "Debes seleccionar un rol para el usuario."
        );
      if (!this.email) this.errorMostrarMsjPersona.push("Ingrese Correo");
      if (this.errorMostrarMsjPersona.length) this.errorPersona = 1;
      return this.errorPersona;
    },
    showModal(accion, modal, row) {
      this.$refs[modal].show();
      switch (accion) {
        case 1:
          this.titulomodal1 = "Nuevo";
          this.tituloaccion = "Guardar";
          this.borrarFormulario();
          break;
        case 2:
          this.titulomodal1 = "Actualizar";
          this.tituloaccion = "Actualizar";
          this.id_contrato = row.id;
          this.tipo_contrato = row.tipo_contrato;
          if (row.tipo_contrato == 1) {
            this.tipo_contrato = "Fijo";
          } else if (row.tipo_contrato == 2) {
            this.tipo_contrato = "Calculado";
          }
          this.num_documentos = row.num_documentos;
          this.desde = row.desde;
          this.hasta = row.hasta;
          this.costo_base = row.costo_base;
          this.costo_excedente = row.costo_excedente;
          this.periodo_mes = row.periodo_mes;
          this.activo = row.activo;
          this.vselectCliente = { id: row.id, nombre: row.nombre };
          break;
      }
    },
    borrarFormulario() {
      this.vselectPersonal = null;
      this.ID_PERSONAL = 0;
      this.TIPO_CONTRATO = "";
      this.ESTADO_CONTRATACIONES = "0";
      this.FECHAINICIO_CONTRATACIONES = "";
      this.FECHAFIN_CONTRATACIONES = "";
      this.OBSERVACIONES_CONTRATACIONES = "";
      this.TOTAL_CONTRATACIONES = 0;
      this.MENSUAL_CONTRATACIONES = 0;
    },
    verRegistro(idregistro) {
      this.tituloaccion = "Actualizar";
      this.verdetalle = 1;
      this.nuevodetalle = 0;
      let me = this;
      var url = "/contrato/verRegistro?buscar=" + idregistro;
      axios
        .get(url)
        .then(function (response) {
          var respuesta = response.data;
          me.registro = respuesta.registro;
          me.ID_CONTRATACIONES = me.registro[0]["ID_CONTRATACIONES"];
          me.ID_PERSONAL = me.registro[0]["ID_PERSONAL"];
          me.CODE_PLAN = me.registro[0]["CODE_PLAN"];
          me.TIPO_CONTRATO = me.registro[0]["TIPO_CONTRATO"];
          me.FECHAINICIO_CONTRATACIONES =
            me.registro[0]["FECHAINICIO_CONTRATACIONES"];
          me.FECHAFIN_CONTRATACIONES =
            me.registro[0]["FECHAFIN_CONTRATACIONES"];
          me.MENSUAL_CONTRATACIONES = me.registro[0]["MENSUAL_CONTRATACIONES"];
          me.ESTADO_CONTRATACIONES = me.registro[0]["ESTADO_CONTRATACIONES"];
          me.TOTAL_CONTRATACIONES = me.registro[0]["TOTAL_CONTRATACIONES"];
          me.OBSERVACIONES_CONTRATACIONES =
            me.registro[0]["OBSERVACIONES_CONTRATACIONES"];
          me.REAL_OBSERVACIONES = me.registro[0]["REAL_OBSERVACIONES"];
          me.DIRECTOR = me.registro[0]["DIRECTOR"];
          me.DOCUMENT_PATH = me.registro[0]["DOCUMENT_PATH"];
          me.NOMBRES_PERSONAL = me.registro[0]["NOMBRES_PERSONAL"];
          me.APELLIDOS_PERSONAL = me.registro[0]["APELLIDOS_PERSONAL"];
          me.vselectPersonal = {
            ID_PERSONAL: me.registro[0]["ID_PERSONAL"],
            NOMBRE:
              me.registro[0]["APELLIDOS_PERSONAL"] +
              " " +
              me.registro[0]["NOMBRES_PERSONAL"],
          };
          me.listPresupuesto();
          me.listFunciones();
          me.listProductos();
          me.listComentarios();
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },
  },
  mounted() {
    this.ListarProyectos(1, "");
    //this.selectRol();
  },
};
</script>