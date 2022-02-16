<template>
  <div>
    <h4 class="font-weight-bold py-3 mb-4">
      <span class="text-muted font-weight-light">Parámetros /</span>
      Financiadores / Ejecutores
      <button
        type="button"
        class="btn btn-sm btn-success"
        @click="showModal(1)"
      >
        <span class="ion ion-md-add-circle-outline"></span>
      </button>
    </h4>
    <div class="form-group row">
      <div class="col-md-5">
        <div class="input-group">
          <input
            type="text"
            v-model="buscar"
            @keyup.enter="ListarRegistros(1, buscar)"
            class="form-control"
            placeholder="Texto a buscar"
          />
          <button
            type="submit"
            @click="ListarRegistros(1, buscar)"
            class="btn btn-primary"
          >
            <i class="fa fa-search"></i> Buscar
          </button>
        </div>
      </div>
    </div>
    <hr class="container-m-nx border-light mt-0 mb-5" />

    <v-client-table :data="tableData" :columns="columns" :options="options">
      <template slot="accion" slot-scope="props">
        <div>
          <b-btn
            variant="outline-success borderless icon-btn"
            class="btn-xs"
            @click="showModal(2, props.row)"
            ><i class="ion ion-md-create"></i
          ></b-btn>
          <b-btn
            variant="outline-danger borderless icon-btn"
            class="btn-xs"
            @click="deleteRegistro(props.row.ID_FINANCIADOR)"
            ><i class="ion ion-md-trash"></i
          ></b-btn>
        </div>
      </template>
      <!-- <template slot="child_row" slot-scope="props">
        <div><b>First name:</b> {{props.row.first_name}}</div>
        <div><b>Last name:</b> {{props.row.last_name}}</div>
      </template> -->
    </v-client-table>
    Total Documentos: {{ paginacion.total }}
    <b-pagination
      size="lg"
      :total-rows="paginacion.total"
      v-model="currentPage"
      :per-page="10"
      @change="pageChange"
    />

    <b-card-body>
      <b-modal
        ref="modal-1"
        id="modal-1"
        size="xl"
        cancel-title="Cancelar"
        ok-title="Guardar"
        @cancel="metodocancelar()"
        @ok="metodook"
      >
        <div slot="modal-title">
          {{ titulomodal1 }}
          <span class="font-weight-light">Financiador</span>
          <b-btn
            variant="outline-success borderless icon-btn"
            class="btn-m"
            @click="showModal(3, 0)"
            v-if="tituloaccion == 'Visualizar'"
            ><i class="ion ion-md-create"></i
          ></b-btn>
          <!-- <small class="text-muted">We need payment information to process your order.</small> -->
        </div>
        <b-form-row>
          <b-form-group label="Nombre del Financiador" class="col-12">
            <b-input
              v-model="NOMBRE_FINANCIADOR"
              placeholder="Nombre del financiador"
              ref="descripcion"
              :disabled="disabled"
            />
          </b-form-group>
        </b-form-row>
        <b-form-row>
          <b-form-group label="Contacto" class="col-6">
            <b-input
              v-model="CONTACTO_FINANCIADOR"
              placeholder="Nombre del financiador"
              ref="descripcion"
              :disabled="disabled"
            />
          </b-form-group>
          <b-form-group label="Correo" class="col-6">
            <b-input
              v-model="EMAIL_FINANCIADOR"
              placeholder="Nombre del financiador"
              ref="descripcion"
              :disabled="disabled"
            />
          </b-form-group>
        </b-form-row>
        <b-form-row>
          <b-form-group label="Fijo" class="col-4">
            <b-input
              v-model="TELEF1_FINANCIADOR"
              placeholder="Nombre del financiador"
              ref="descripcion"
              :disabled="disabled"
            />
          </b-form-group>
          <b-form-group label="Celular" class="col-4">
            <b-input
              v-model="TELEF2_FINANCIADOR"
              placeholder="Nombre del financiador"
              ref="descripcion"
              :disabled="disabled"
            />
          </b-form-group>
          <b-form-group label="Internacional" class="col-4">
            <b-input
              v-model="TELEF3_FINANCIADOR"
              placeholder="Nombre del financiador"
              ref="descripcion"
              :disabled="disabled"
            />
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
    </b-card-body>
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
    vselectCliente: null,
    buscar: "",
    currentPage: 1,
    modal: 0,
    //modal data
    ID_FINANCIADOR: 0,
    NOMBRE_FINANCIADOR: "",
    CONTACTO_FINANCIADOR: "",
    TELEF1_FINANCIADOR: "",
    TELEF2_FINANCIADOR: "",
    TELEF3_FINANCIADOR: "",
    EMAIL_FINANCIADOR: "",
    activo: 1,
    titulomodal1: "",
    arrayFinanciador: [],
    //fin modal data-----
    errorPersona: 0,
    errorMostrarMsjPersona: [],
    //table data
    tableData: [],
    columns: [
      "NOMBRE_FINANCIADOR",
      "CONTACTO_FINANCIADOR",
      "TELEF1_FINANCIADOR",
      "TELEF2_FINANCIADOR",
      "EMAIL_FINANCIADOR",
      "accion",
    ],
    options: {
      filterable: false,
      headings: {
        NOMBRE_FINANCIADOR: "Financiador",
        CONTACTO_FINANCIADOR: "Contacto",
        TELEF1_FINANCIADOR: "Fijo",
        TELEF2_FINANCIADOR: "Celular",
        EMAIL_FINANCIADOR: "Correo",
      },
      templates: {},
    },
    paginacion: {
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
      me.ListarRegistros(page, buscar);
    },
    pageChange(page) {
      this.currentPage = page;
      this.ListarRegistros(page, ""); // api call
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
    metodook(bvModalEvt) {
      bvModalEvt.preventDefault();
      this.registrarNuevo();
    },
    ListarRegistros(page, buscar) {
      let me = this;
      var url = "/financiador/index?page=" + page + "&buscar=" + buscar;
      axios
        .get(url)
        .then(function (response) {
          var respuesta = response.data;
          me.tableData = respuesta.registros.data;
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
    registrarNuevo() {
      // if (this.validarRegistro()){
      //     return;
      // }
      let me = this;
      if (this.tituloaccion == "Guardar") {
        axios
          .post("/financiador/registrar", {
            NOMBRE_FINANCIADOR: this.NOMBRE_FINANCIADOR,
            CONTACTO_FINANCIADOR: this.CONTACTO_FINANCIADOR,
            TELEF1_FINANCIADOR: this.TELEF1_FINANCIADOR,
            TELEF2_FINANCIADOR: this.TELEF2_FINANCIADOR,
            TELEF3_FINANCIADOR: this.TELEF3_FINANCIADOR,
            EMAIL_FINANCIADOR: this.EMAIL_FINANCIADOR,
          })
          .then(function (response) {
            me.ListarRegistros(1, "");
            me.msjform("Correcto", "Grabado exitosamente", "success");
            me.$nextTick(() => {
              me.$bvModal.hide("modal-1");
            });
          })
          .catch(function (error) {
            // handle error
            console.log(error);
            me.msjform("Registro ya existe", "No se ha registrado", "danger");
          });
      } else if (this.tituloaccion == "Actualizar") {
        axios
          .put("/financiador/actualizar", {
            id: this.ID_FINANCIADOR,
            NOMBRE_FINANCIADOR: this.NOMBRE_FINANCIADOR,
            CONTACTO_FINANCIADOR: this.CONTACTO_FINANCIADOR,
            TELEF1_FINANCIADOR: this.TELEF1_FINANCIADOR,
            TELEF2_FINANCIADOR: this.TELEF2_FINANCIADOR,
            TELEF3_FINANCIADOR: this.TELEF3_FINANCIADOR,
            EMAIL_FINANCIADOR: this.EMAIL_FINANCIADOR,
          })
          .then(function (response) {
            me.ListarRegistros(1, "");
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
    validarRegistro() {
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
    showModal(accion, row) {
      this.$refs["modal-1"].show();
      switch (accion) {
        case 1:
          this.titulomodal1 = "Nuevo";
          this.tituloaccion = "Guardar";
          this.borrarFormulario();
          this.disabled = false;
          break;
        case 2:
          this.titulomodal1 = "Visualizar";
          this.tituloaccion = "Visualizar";
          this.ID_FINANCIADOR = row.ID_FINANCIADOR;
          this.NOMBRE_FINANCIADOR = row.NOMBRE_FINANCIADOR;
          this.CONTACTO_FINANCIADOR = row.CONTACTO_FINANCIADOR;
          this.TELEF1_FINANCIADOR = row.TELEF1_FINANCIADOR;
          this.TELEF2_FINANCIADOR = row.TELEF2_FINANCIADOR;
          this.TELEF3_FINANCIADOR = row.TELEF3_FINANCIADOR;
          this.EMAIL_FINANCIADOR = row.EMAIL_FINANCIADOR;
          this.disabled = true;
          break;
        case 3:
          this.titulomodal1 = "Actualizar";
          this.tituloaccion = "Actualizar";
          this.disabled = false;
          break;
      }
    },
    borrarFormulario() {
      this.NOMBRE_FINANCIADOR = "";
      this.CONTACTO_FINANCIADOR = "";
      this.TELEF1_FINANCIADOR = "";
      this.TELEF2_FINANCIADOR = "";
      this.TELEF3_FINANCIADOR = "";
      this.EMAIL_FINANCIADOR = "";
    },
    deleteRegistro(idregistro) {
      let me = this;
      axios
        .post("/financiador/destroy", {
          id: idregistro,
        })
        .then(function (response) {
          me.ListarRegistros(1, "");
          me.msjform("Correcto", "Eliminado exitosamente", "success");
        })
        .catch(function (error) {
          // handle error
          console.log(error);
          me.msjform("No se puede eliminar", "No se ha registrado", "danger");
        });
    },
  },
  mounted() {
    this.ListarRegistros(1, "");
    //this.selectRol();
  },
};
</script>