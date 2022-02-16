<template>
  <div>
    <h4 class="font-weight-bold py-3 mb-4">
      <span class="text-muted font-weight-light">Parámetros /</span> Tipos de Adjuntos
      <button type="button" class="btn btn-sm btn-success" @click="showModal(1)">
        <span class="ion ion-md-add-circle-outline"></span>
      </button>
    </h4>
  <div class="form-group row">
        <div class="col-md-5">
            <div class="input-group">
                <input type="text" v-model="buscar" @keyup.enter="ListarRegistros(1,buscar)" class="form-control" placeholder="Texto a buscar">
                <button type="submit" @click="ListarRegistros(1,buscar)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
            </div>
        </div>
    </div>
    <hr class="container-m-nx border-light mt-0 mb-5">

    <v-client-table :data="tableData" :columns="columns" :options="options">
      
      <template slot="accion" slot-scope="props">
        <div>
          <b-btn variant="outline-success borderless icon-btn" class="btn-xs"  @click="showModal(2,props.row)"><i class="ion ion-md-create"></i></b-btn>
        </div>
      </template>
      <!-- <template slot="child_row" slot-scope="props">
        <div><b>First name:</b> {{props.row.first_name}}</div>
        <div><b>Last name:</b> {{props.row.last_name}}</div>
      </template> -->
    </v-client-table>
    Total Documentos: {{ paginacion.total }}
    <b-pagination size="lg" :total-rows="paginacion.total" v-model="currentPage" :per-page="10" @change="pageChange"/>

    <b-card-body>
      <b-modal ref="modal-1" id="modal-1" size="sm" cancel-title="Cancelar" ok-title="Guardar" @cancel="metodocancelar()" @ok="metodook">
          <div slot="modal-title">
            {{titulomodal1}} <span class="font-weight-light">Tipo de Adjunto</span>             
              <b-btn variant="outline-success borderless icon-btn" class="btn-m"  @click="showModal(3,0)" v-if="tituloaccion=='Visualizar'"><i class="ion ion-md-create"></i></b-btn>                 
            <!-- <small class="text-muted">We need payment information to process your order.</small> -->
          </div>
          <b-form-row>
            <b-form-group label="Tipo de Adjunto" class="col-12">
              <b-input v-model="descripcion" placeholder="Tipo de Documento adjunto de Proyectos" ref="descripcion" :disabled='disabled' />
            </b-form-group>
          </b-form-row>
          <div v-show="errorPersona" class="form-group row div-error">
            <div class="text-center text-error">
                <div v-for="error in errorMostrarMsjPersona" :key="error" v-text="error">

                </div>
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
import Vue from 'vue'
import { ClientTable } from 'vue-tables-2'
import 'vue-select/dist/vue-select.css';

Vue.use(ClientTable)
import { PaginationPlugin } from 'bootstrap-vue'
Vue.use(PaginationPlugin)

import Multiselect from 'vue-multiselect'

import vSelect from 'vue-select'

export default {
  name: 'tables-vue-tables-2',
  metaInfo: {
    title: 'Vue Tables 2 - Tables'
  },
  components: {
    Multiselect,
    vSelect
  },
  data: () => ({
    arrayCliente:[],
    vselectCliente: null,
    buscar: '',
    currentPage: 1,
    modal : 0,
    //modal data
    id_registro : 0,
    descripcion : '',
    tipo_contrato : '', //1=Fijo 2=calculado
    tipocontrato : 0,
    disabled : false,
    desde : '',
    hasta: '',
    periodo_mes : 0,
    activo: 1,
    titulomodal1: '',
    arrayRol : [],
    //fin modal data-----
    errorPersona : 0,
    errorMostrarMsjPersona : [],
    //table data
    tableData: [],
    columns: ['id', 'descripcion','accion'],
    options: {
      filterable: false,
      headings: {
                id: 'Nº',
                descripcion: 'Descripción',
                accion: 'Acción',
            },
      templates:{  
      }
    },
    paginacion : {
                    'total' : 0,       
                    'current_page' : 0, 
                    'per_page' : 0,     
                    'last_page' : 0,    
                    'from' : 0,         
                    'to' : 0,           
                },
    //fin table data------
  }),
  created () {
    // Fetch json data

  },
  computed: {
            isActived: function (){
                return this.paginacion.current_page;
            },
            pagesNumber: function () {
                if(!this.paginacion.to){
                    return [];
                }

                var from = this.paginacion.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
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
    cambiarPagina(page,buscar){
        let me = this;
        //actualiza la pag actual
        me.pagination.current_page = page;
        me.ListarRegistros(page,buscar);
    },
    pageChange (page) {
    this.currentPage = page
    this.ListarRegistros(page,'') // api call
    },
    msjform (header, text, variant) {
      this.$bvToast.toast(`${text}`, {
        title: `${header}`,
        autoHideDelay: 3000,
        appendToast: true,
        toastClass: variant ? `bs4-toast bg-${variant}` : 'bs4-toast'
      })
    },
    metodocancelar (){
      //this.nombre="metodo cancelar";
    },
    metodook (bvModalEvt){
      bvModalEvt.preventDefault();
      this.registrarNuevo();    
    },
    ListarRegistros (page,buscar){
        let me=this;
        var url= '/tipoadjunto?page=' + page + '&buscar='+ buscar;
        axios.get(url).then(function (response) {
            var respuesta=response.data;
            me.tableData = respuesta.datos.data;
            me.paginacion=respuesta.pagination;
            // handle success
            //console.log(response);
            // me.arrayBanco = response.data;
        })
        .catch(function (error) {
            // handle error
            console.log(error);
        });
      },
      registrarNuevo(){
        // if (this.validarContrato()){
        //     return;
        // }
        let me = this;
        if (this.tituloaccion=="Guardar") {
          axios.post('/tipoadjunto/registrar',{
            'descripcion': this.descripcion,

          }).then(function (response) {
              me.ListarRegistros(1,'');
              me.msjform('Correcto','Grabado exitosamente','success');
              me.$nextTick(() => {
                me.$bvModal.hide('modal-1')
              })
          }).catch(function (error) {
                    // handle error
                    console.log(error);
                    me.msjform('Registro ya existe','No se ha registrado','danger');
                });
        }else if (this.tituloaccion=="Actualizar") {
          axios.put('/tipoadjunto/actualizar',{
            'id': this.id_registro,
            'descripcion': this.descripcion,

          }).then(function (response) {
              me.ListarRegistros(1,'');
              me.msjform('Correcto','Actualizado exitosamente','success');
              me.$nextTick(() => {
                me.$bvModal.hide('modal-1')
              })
          }).catch(function (error) {
              // handle error
              console.log(error);
              me.msjform('Error','No se pudo actualizar','danger');
          });
        }
        
    },
    validarContrato(){
        this.errorPersona=0;
        this.errorMostrarMsjPersona =[];

        if (!this.nombre) this.errorMostrarMsjPersona.push("El nombre de la persona no puede estar vacío.");
        if (!this.usuario) this.errorMostrarMsjPersona.push("Ingrese Identificación");
        if (!this.password) this.errorMostrarMsjPersona.push("El password no puede estar vacío.");
        if (this.tipo_dni==0) this.errorMostrarMsjPersona.push("Elija tipo de Identificación");
        if (this.id_rol==0) this.errorMostrarMsjPersona.push("Debes seleccionar un rol para el usuario.");
        if (!this.email) this.errorMostrarMsjPersona.push("Ingrese Correo");
        if (this.errorMostrarMsjPersona.length) this.errorPersona = 1;
        return this.errorPersona;
    },
    showModal(accion,row) {
      this.$refs['modal-1'].show();
      switch (accion) {
        case 1:
          this.titulomodal1='Nuevo';
          this.tituloaccion='Guardar';
          this.borrarFormulario();
          this.disabled=false;
        break;
        case 2:
          this.titulomodal1='Visualizar';
          this.tituloaccion='Visualizar';
          this.id_registro= row.id;
          this.descripcion=row.descripcion;
          this.disabled=true;
        break;
        case 3:
          this.titulomodal1='Actualizar';
          this.tituloaccion='Actualizar';
          this.disabled=false;
        break;
      }
      
    },
    borrarFormulario (){
      this.descripcion='';
    },

  },
  mounted() {
            this.ListarRegistros(1,'');
            //this.selectRol();
        }
}
</script>