<template>
  <div>
    <h4 class="font-weight-bold py-3 mb-4">
      <span class="text-muted font-weight-light">Administración /</span>
      Usuarios
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
            @keyup.enter="ListarUsuarios(1, buscar)"
            class="form-control"
            placeholder="Nombre / RUC / Cédula"
          />
          <button
            type="submit"
            @click="ListarUsuarios(1, buscar)"
            class="btn btn-primary"
          >
            <i class="fa fa-search"></i> Buscar
          </button>
        </div>
        <br />
        <select class="form-control" v-model="tipo_cliente">
          <option value="0">Seleccione un rol</option>
          <option
            v-for="rol in arrayRol"
            :key="rol.id"
            :value="rol.id"
            v-text="rol.nombre"
          ></option>
        </select>
      </div>
    </div>
    <hr class="container-m-nx border-light mt-0 mb-5" />

    <v-client-table :data="tableData" :columns="columns" :options="options">
      <template slot="accion" slot-scope="props">
        <div>
          <b-btn
            variant="outline-warning borderless icon-btn"
            class="btn-xs"
            @click="showModal(2, props.row)"
            ><i class="ion ion-md-create"></i
          ></b-btn>
          <b-btn
            variant="outline-danger borderless icon-btn"
            class="btn-xs"
            @click.prevent="remove(props.row)"
            ><i class="ion ion-md-close-circle-outline"></i
          ></b-btn>
          <b-btn
            variant="outline-success borderless icon-btn"
            class="btn-xs"
            @click="showModalpass(3, props.row)"
            ><i class="ion ion-md-key"></i
          ></b-btn>
        </div>
      </template>
    </v-client-table>
    Total Usuarios: {{ paginacion.total }}
    <b-card-body>
      <b-pagination
        size="md"
        :total-rows="paginacion.total"
        v-model="currentPage"
        :per-page="10"
        @change="pageChange"
      />
      <b-modal
        ref="modal-1"
        id="modal-1"
        :size="null"
        cancel-title="Cancelar"
        :ok-title="tituloaccion"
        @cancel="metodocancelar()"
        @ok="metodook"
      >
        <div slot="modal-title">
          {{ titulomodal1 }} <span class="font-weight-light">Usuario</span
          ><br />
          <!-- <small class="text-muted">We need payment information to process your order.</small> -->
        </div>
        <b-form-row>
          <b-form-group label="Nombre Completo" class="col">
            <b-input type="text" v-model="nombre" placeholder="----" />
          </b-form-group>
        </b-form-row>
        <b-form-row>
          <b-form-group label="Tipo de identificación" class="col-4">
            <template>
              <b-form-input
                list="tipo-documento"
                v-model="tipo_dni"
              ></b-form-input>
              <datalist id="tipo-documento" placeholder="dsasawd">
                <option value="Cédula"></option>
                <option value="RUC"></option>
                <option value="Pasaporte"></option>
                <option value="Usuario"></option>
              </datalist>
            </template>
          </b-form-group>
          <b-form-group label="Identificación/Nombre de Usuario" class="col-8">
            <b-input v-model="usuario" placeholder="----" />
          </b-form-group>
        </b-form-row>
        <b-form-row>
          <b-form-group
            label="Contraseña"
            class="col"
            v-if="(titulomodal1 = 'Nuevo')"
          >
            <b-input
              type="password"
              v-model="password"
              placeholder="**********"
            />
          </b-form-group>
        </b-form-row>
        <b-form-row>
          <b-form-group label="Correo" class="col-8">
            <b-input
              type="email"
              v-model="email"
              placeholder="usuario@dominio.com"
            />
          </b-form-group>
          <b-form-group label="Perfil" class="col-4">
            <select class="form-control" v-model="id_rol">
              <option value="0">Todos...</option>
              <option
                v-for="rol in arrayRol"
                :key="rol.id"
                :value="rol.id"
                v-text="rol.nombre"
              ></option>
            </select>
          </b-form-group>
        </b-form-row>
        <b-form-row>
          <b-form-group
            label="Estado Facturación"
            class="col-6"
            v-if="id_rol == 2"
          >
            <template>
              <b-form-input
                list="estado_facturacion"
                v-model="estado_facturacion"
              ></b-form-input>
              <datalist id="estado_facturacion" placeholder="elegir">
                <option value="Inactivo"></option>
                <option value="Activo"></option>
                <option value="Adeuda"></option>
                <option value="Suspendido"></option>
              </datalist>
            </template>
          </b-form-group>
          <b-form-group
            label="Plazo Hasta"
            class="col-6"
            v-if="estado_facturacion == 'Adeuda' && id_rol == 2"
          >
            <b-input type="date" v-model="plazo" />
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
      <b-modal
        ref="modal-2"
        id="modal-2"
        :size="null"
        cancel-title="Cancelar"
        :ok-title="tituloaccion2"
        @cancel="metodocancelarpass()"
        @ok="metodookpass"
      >
        <div slot="modal">
          Actualizar <span class="font-weight-light">Contraseña</span><br />
          <!-- <small class="text-muted">We need payment information to process your order.</small> -->
        </div>
        <b-form-row>
          <b-form-group label="Nombre Completo" class="col">
            <b-input type="text" v-model="nombre" placeholder="----" disabled />
          </b-form-group>
        </b-form-row>
        <b-form-row>
          <b-form-group label="Contraseña" class="col">
            <b-input
              type="password"
              v-model="password"
              placeholder="**********"
            />
          </b-form-group>
        </b-form-row>
        <b-form-row>
          <b-form-group label="Correo" class="col">
            <b-input
              type="password"
              v-model="passwordconfirm"
              placeholder="**********"
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
<style src="@/vendor/libs/vue-notification/vue-notification.scss" lang="scss"></style>


<script>
import Vue from "vue";
import { ClientTable } from "vue-tables-2";
import Notifications from "vue-notification";

Vue.use(ClientTable);
import { PaginationPlugin } from "bootstrap-vue";
Vue.use(PaginationPlugin);

export default {
  name: "tables-vue-tables-2",
  metaInfo: {
    title: "Vue Tables 2 - Tables",
  },
  data: () => ({
    accion: 0,
    accionletra: "",
    arrayRol: [],
    buscar: "",
    currentPage: 1,
    email: "",
    modal: 0,
    id_rol: 0,
    id_user: 0,
    nombre: "",
    tipo_dni: "", //1=cedula 2=ruc 3=pasaporte 4=usuario adm
    tipodni: 0,
    tipo_cliente: 0,
    password: "",
    passwordconfirm: "",
    plazo: "",
    usuario: "",
    estado_facturacion: "",
    titulomodal1: "",
    tituloaccion: "",
    tituloaccion2: "",
    sis_activo: 0,

    //fin modal data-----
    errorPersona: 0,
    errorMostrarMsjPersona: [],
    //table data
    tableData: [],
    columns: [
      "APELLIDOS_PERSONAL",
      "usuario",
      "ROLE",
      "EMAIL_PERSONAL",
      "accion",
    ],
    options: {
      filterable: false,
      headings: {
        APELLIDOS_PERSONAL: "Nombre",
        usuario: "usuario",
        ROLE: "Perfil",
        EMAIL_PERSONAL: "Correo",
        accion: "Acción",
      },
      templates: {
        APELLIDOS_PERSONAL(h, row) {
          return row.APELLIDOS_PERSONAL+' '+row.NOMBRES_PERSONAL;
        },
        MAIL_USU(h, row) {
          if (row.MAIL_USU=='') {
            return 'N/A';
          }
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
      me.ListarUsuarios(page, buscar);
    },
    pageChange(page) {
      this.currentPage = page;
      this.ListarUsuarios(page, ""); // api call
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
      this.borrarFormulario();
    },
    remove(row) {
      let me = this;
      this.id_user = row.id_usuario;
      axios
        .post("/user/destroy", {
          id: this.id_user,
        })
        .then(function (response) {
          // handle success
          //console.log(response);
        })
        .catch(function (error) {
          // handle error
          console.log(error);
          this.ListarUsuarios(1, "");
        });
    },
    metodook(bvModalEvt) {
      //this.registrarPersona();
      bvModalEvt.preventDefault();
      this.registrarPersona();
    },
    metodookpass(bvModalEvt) {
      //this.registrarPersona();
      bvModalEvt.preventDefault();
      this.updatepass();
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
    updatepass() {
      if (this.validarpass()) {
        return;
      }
      let me = this;
      var url = "/user/changepass";
      axios
        .put(url, {
          id: this.id_user,
          password: this.password,
        })
        .then(function (response) {
          me.$nextTick(() => {
            me.$bvModal.hide("modal-2");
          });
          me.ListarUsuarios(1, this.buscar);
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },
    validarpass() {
      this.errorPersona = 0;
      this.errorMostrarMsjPersona = [];
      if (this.password != this.passwordconfirm) {
        this.errorMostrarMsjPersona.push("La contraseña no coincide");
        this.errorPersona = 1;
      }
      return this.errorPersona;
    },
    ListarUsuarios(page, buscar) {
      let me = this;
      var url =
        "/user?page=" +
        page +
        "&buscar=" +
        buscar +
        "&tipo_cliente=" +
        this.tipo_cliente;
      axios
        .get(url)
        .then(function (response) {
          var respuesta = response.data;
          me.tableData = respuesta.personas.data;
          me.paginacion = respuesta.pagination;
          // me.pagination=respuesta.pagination;
          // handle success
          //console.log(response);
          // me.arrayBanco = response.data;
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },
    registrarPersona() {
      if (this.validarPersona()) {
        return;
      }
      switch (this.tipo_dni) {
        case "Cédula":
          this.tipodni = 1;
          break;
        case "RUC":
          this.tipodni = 2;
          break;
        case "Pasaporte":
          this.tipodni = 3;
          break;
        case "Usuario":
          this.tipodni = 4;
          break;
        default:
          break;
      }
      switch (this.estado_facturacion) {
        case "Inactivo":
          this.sis_activo = 0;
          break;
        case "Activo":
          this.sis_activo = 1;
          break;
        case "Adeuda":
          this.sis_activo = 2;
          break;
        case "Suspendido":
          this.sis_activo = 3;
          break;
        default:
          break;
      }
      let me = this;
      if (this.tituloaccion == "Guardar") {
        var uri = "/user/registrar";
        axios
          .post(uri, {
            nombre: this.nombre,
            tipo_dni: this.tipodni,
            direccion: this.direccion,
            email: this.email,
            usuario: this.usuario,
            password: this.password,
            condicion: this.condicion,
            idrol: this.id_rol,
            sis_activo: this.sis_activo,
            plazo: this.plazo,
          })
          .then(function (response) {
            me.ListarUsuarios(1, "");
            me.msjform("Correcto", "Grabado exitosamente", "success");
            me.$nextTick(() => {
              me.$bvModal.hide("modal-1");
            });
          })
          .catch(function (error) {
            // handle error
            console.log(error);
            me.msjform("Usuario ya existe", "No se ha registrado", "danger");
          });
      } else if (this.tituloaccion == "Actualizar") {
        var uri = "/user/actualizar";
        if (this.sis_activo != 2) {
          this.plazo = null;
        }
        axios
          .put(uri, {
            id: this.id_user,
            nombre: this.nombre,
            tipo_dni: this.tipodni,
            direccion: this.direccion,
            email: this.email,
            usuario: this.usuario,
            password: this.password,
            condicion: this.condicion,
            idrol: this.id_rol,
            sis_activo: this.sis_activo,
            plazo: this.plazo,
          })
          .then(function (response) {
            me.ListarUsuarios(1, me.buscar);
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
    validarPersona() {
      this.errorPersona = 0;
      this.errorMostrarMsjPersona = [];

      if (!this.nombre)
        this.errorMostrarMsjPersona.push(
          "El nombre de la persona no puede estar vacío."
        );
      if (!this.usuario)
        this.errorMostrarMsjPersona.push("Ingrese Identificación");
      if (this.tituloaccion == "Guardar") {
        if (!this.password)
          this.errorMostrarMsjPersona.push("El password no puede estar vacío.");
      }
      if (this.tipo_dni == 0)
        this.errorMostrarMsjPersona.push("Elija tipo de Identificación");
      if (this.id_rol == 0)
        this.errorMostrarMsjPersona.push(
          "Debes seleccionar un rol para el usuario."
        );
      //if (!this.email) this.errorMostrarMsjPersona.push("Ingrese Correo");
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
          break;
        case 2:
          this.titulomodal1 = "Actualizar";
          this.tituloaccion = "Actualizar";
          this.nombre = row.nombre;
          this.tipo_dni = this.tipodniletra(row.tipo_dni);
          this.usuario = row.usuario;
          this.password = row.password;
          this.email = row.email;
          this.id_rol = row.id_rol;
          this.estado_facturacion = this.estadofacletra(row.sis_activo);
          this.id_user = row.id_usuario;
          this.plazo = row.plazo;
          break;
      }
    },
    showModalpass(accion, row) {
      this.$refs["modal-2"].show();
      this.nombre = row.APELLIDOS_PERSONAL+' '+row.NOMBRES_PERSONAL;
      this.id_user = row.id;
      this.tituloaccion2 = "Actualizar";
      this.password = "";
      this.passwordconfirm = "";
    },
    tipodniletra(tipo) {
      switch (tipo) {
        case 1:
          return "Cédula";
          break;
        case 2:
          return "RUC";
          break;
        case 3:
          return "Pasaporte";
          break;
        case 4:
          return "Usuario";
          break;
        default:
          break;
      }
    },
    estadofacletra(tipo) {
      switch (tipo) {
        case 0:
          return "Inactivo";
          break;
        case 1:
          return "Activo";
          break;
        case 2:
          return "Adeuda";
          break;
        case 3:
          return "Suspendido";
          break;
        default:
          break;
      }
    },
    borrarFormulario() {
      this.nombre = "";
      this.tipo_dni = "";
      this.usuario = "";
      this.password = "";
      this.email = "";
      this.id_rol = 0;
      this.sis_activo = 1;
      this.titulomodal1 = "";
    },
  },
  mounted() {
    this.ListarUsuarios(1, "");
    this.selectRol();
  },
};
</script>