<template>
  <div>
    <h4 class="font-weight-bold py-3 mb-4">
      <span class="text-muted font-weight-light">Trámites /</span> Oficios
      <button type="button" class="btn btn-sm btn-success" @click="showModal(1)">
        <span class="ion ion-md-add-circle-outline"></span>
      </button>
    </h4>
  <div class="form-group row">
        <div class="col-md-5">
            <div class="input-group">
                <input type="text" v-model="buscar" @keyup.enter="ListarOficios(1,buscar)" class="form-control" placeholder="Texto a buscar">
                <button type="submit" @click="ListarOficios(1,buscar)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
            </div>
        </div>
    </div>
    <hr class="container-m-nx border-light mt-0 mb-5">

    <v-client-table :data="tableData" :columns="columns" :options="options">
      
      <template slot="accion" slot-scope="props">
        <div>
          <b-btn variant="outline-warning borderless icon-btn" class="btn-xs"  @click="showModal(2,props.row)"><i class="ion ion-md-create"></i></b-btn>
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
      <b-modal ref="modal-1" id="modal-1" size="xl" cancel-title="Cancelar" ok-title="Guardar" @cancel="metodocancelar()" @ok="metodook">
          <div slot="modal-title">
            {{titulomodal1}} <span class="font-weight-light">Proyecto</span> 
            
              <b-btn variant="outline-warning borderless icon-btn" class="btn-sm"  @click="showModal(2,props.row)"><i class="ion ion-md-create"></i></b-btn>
                 
            <!-- <small class="text-muted">We need payment information to process your order.</small> -->
          </div>
          <b-form-row>
            <b-form-group label="Código PUCE" class="col-3">
              <template>
                <b-form-input list="tipo-contrato" placeholder="Enter Price" v-model="tipo_contrato"></b-form-input>
              </template>
            </b-form-group>
            <b-form-group label="Nombre del Proyecto" class="col-9">
              <b-input v-model="num_documentos" placeholder=""/>
            </b-form-group>
          </b-form-row>
          <b-form-row>
            <b-form-group label="Fecha Inicio" class="col-2">
              <b-input v-model="num_documentos" placeholder=""/>
            </b-form-group>
            <b-form-group label="Fecha Finalización" class="col-2">
              <b-input v-model="num_documentos" placeholder=""/>
            </b-form-group>
            <b-form-group label="Financiador" class="col-4">
                <b-input v-model="num_documentos" placeholder=""/>
            </b-form-group>
            <b-form-group label="Director" class="col-4">
                <b-input v-model="num_documentos" placeholder=""/>
            </b-form-group>
          </b-form-row>
          <b-form-row>
            <b-form-group label="Enunciado" class="col-6">
              <template>
                <b-form-input list="tipo-contrato" placeholder="Enter Price" v-model="tipo_contrato"></b-form-input>
              </template>
            </b-form-group>
            <b-form-group label="Propósito" class="col-6">
              <b-input v-model="num_documentos" placeholder=""/>
            </b-form-group>
          </b-form-row>
          <b-form-row>
            <b-form-group label="Monto Total Propuesto" class="col-3">
              <b-input v-model="num_documentos" placeholder=""/>
            </b-form-group>
            <b-form-group label="Estado" class="col-3">
              <b-input v-model="num_documentos" placeholder=""/>
            </b-form-group>
            <b-form-group label="Adjunto 1" class="col-3">
                <b-input v-model="num_documentos" placeholder=""/>
            </b-form-group>
            <b-form-group label="Adjunto 2" class="col-3">
                <b-input v-model="num_documentos" placeholder=""/>
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
    id_rol : 0,
    id_contrato : 0,
    nombre : '',
    costo_base : 0.00,
    costo_excedente : 0.00,
    num_documentos : 0,
    tipo_contrato : '', //1=Fijo 2=calculado
    tipocontrato : 0,
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
    columns: ['CODIGO_PROYECTO', 'DESCRIPCION_PROYECTO', 'NOMBRE_FINANCIADOR', 'ID_PERSONAL','COSTO_PROYECTO','FECHAINICIO_PROYECTO','FECHAFIN_PROYECTO','accion'],
    options: {
      filterable: false,
      headings: {
                CODIGO_PROYECTO: 'CÓDIGO',
                DESCRIPCION_PROYECTO: 'NOMBRE DEL PROYECTO',
                NOMBRE_FINANCIADOR: 'FINANCIADOR',
                ID_PERSONAL: 'DIRECTOR',
                COSTO_PROYECTO: 'MONTO',
                FECHAINICIO_PROYECTO: 'FECHA INICIO',
                FECHAFIN_PROYECTO: 'FECHA FIN',
            },
      templates:{
        ID_PERSONAL(h, row){
            return row.NOMBRES_PERSONAL+' '+row.APELLIDOS_PERSONAL;
          
        },        
        tipo_contrato(h, row){
          if (row.tipo_contrato==1) {
            return "Fijo";
          } else if (row.tipo_contrato==2) {
            return "Calculado";
          }
        },
        sis_activo(h, row){
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
        me.ListarOficios(page,buscar);
    },
    pageChange (page) {
    this.currentPage = page
    this.ListarOficios(page,'') // api call
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
    selectCliente (search,loading){
                let me=this;
                loading(true)
                var url= '/user/selectUser?filtro='+search;
                axios.get(url).then(function (response) {
                    let respuesta=response.data;
                    q:search
                    me.arrayCliente = respuesta.clientes;
                    loading(false)
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
    metodook (bvModalEvt){
      bvModalEvt.preventDefault();
      this.registrarContrato();    
    },
    selectRol(){
        let me=this;
        var url= '/rol/selectRol';
        axios.get(url).then(function (response) {
            var respuesta= response.data;
            me.arrayRol = respuesta.roles;
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    ListarOficios (page,buscar){
        let me=this;
        var url= '/proyecto?page=' + page + '&buscar='+ buscar;
        axios.get(url).then(function (response) {
            var respuesta=response.data;
            me.tableData = respuesta.proyectos.data;
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
      registrarContrato(){
        // if (this.validarContrato()){
        //     return;
        // }
        switch (this.tipo_contrato) {
          case 'Fijo':
            this.tipocontrato=1;
            break;
          case 'Calculado':
            this.tipocontrato=2;
            break;
          default:
            break;
        }
        let me = this;
        if (this.tituloaccion=="Guardar") {
          axios.post('/contrato/registrar',{
            'id_cliente': this.vselectCliente.id,
            'tipo_contrato': this.tipocontrato,
            'num_documentos' : this.num_documentos,
            'desde' : this.desde,
            'hasta' : this.hasta,
            'costo_base': this.costo_base,
            'costo_excedente': this.costo_excedente,
            'periodo_mes' : this.periodo_mes,
            'activo' : this.activo,

          }).then(function (response) {
              me.ListarOficios(1,'');
              me.msjform('Correcto','Grabado exitosamente','success');
              me.$nextTick(() => {
                me.$bvModal.hide('modal-1')
              })
          }).catch(function (error) {
                    // handle error
                    console.log(error);
                    me.msjform('Usuario ya existe','No se ha registrado','danger');
                });
        }else if (this.tituloaccion=="Actualizar") {
          axios.put('/contrato/actualizar',{
            'id': this.id_contrato,
            'id_cliente': this.vselectCliente.id,
            'tipo_contrato': this.tipocontrato,
            'num_documentos' : this.num_documentos,
            'desde' : this.desde,
            'hasta' : this.hasta,
            'costo_base': this.costo_base,
            'costo_excedente': this.costo_excedente,
            'periodo_mes' : this.periodo_mes,
            'activo' : this.activo,

          }).then(function (response) {
              me.ListarOficios(1,'');
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
          break;
        case 2:
          this.titulomodal1='Actualizar';
          this.tituloaccion='Actualizar';
          this.id_contrato= row.id;
          this.tipo_contrato=row.tipo_contrato;
          if (row.tipo_contrato==1) {
            this.tipo_contrato='Fijo';
          }else if (row.tipo_contrato==2) {
            this.tipo_contrato='Calculado';
          }
          this.num_documentos=row.num_documentos;
          this.desde=row.desde;
          this.hasta=row.hasta;
          this.costo_base=row.costo_base;
          this.costo_excedente=row.costo_excedente;
          this.periodo_mes=row.periodo_mes;
          this.activo=row.activo;
          this.vselectCliente={id:row.id,nombre:row.nombre};
          break;
      }
      
    },
    borrarFormulario (){
      this.vselectCliente=null;
      this.tipocontrato='';
      this.num_documentos=0;
      this.desde='';
      this.hasta='';
      this.costo_base=0.00;
      this.costo_excedente=0.00;
      this.periodo_mes=0;
      this.activo=1;
    },
  },
  mounted() {
            this.ListarOficios(1,'');
            //this.selectRol();
        }
}
</script>