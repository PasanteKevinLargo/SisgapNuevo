<template>
  <div>
    <h4 class="font-weight-bold py-3 mb-4">
      <span class="text-muted font-weight-light">Proyectos /</span> Proyectos
      <button
        type="button"
        class="btn btn-sm btn-success"
        @click="showModal(1)"
      >
        <span class="ion ion-md-add-circle-outline"></span>
      </button>
    </h4>
    <div class="form-group row">
      <div class="col-md-12">
        <div class="input-group">
          <input
            type="text"
            v-model="buscar"
            @keyup.enter="ListarRegistros(1, buscar)"
            class="form-control col-md-4"
            placeholder="Código / Proyecto / Financiador"
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
            class="btn-m"
            @click="showModal(2, props.row)"
            ><i class="ion ion-md-eye"></i
          ></b-btn>
        </div>
      </template>
      <!-- <template slot="child_row" slot-scope="props">
        <div><b>First name:</b> {{props.row.first_name}}</div>
        <div><b>Last name:</b> {{props.row.last_name}}</div>
      </template> -->
    </v-client-table>
    Total Proyectos: {{ paginacion.total }}

    <b-pagination
      size="lg"
      :total-rows="paginacion.total"
      v-model="currentPage"
      :per-page="10"
      @change="pageChange"
    />
    <!-- inicio modal proyecto -->
    <b-card-body>
      <b-modal
        ref="modal-proyecto"
        id="modal-proyecto"
        size="xl"
        cancel-title="Cancelar"
        ok-title="Guardar"
        hide-title="Guardar 2"
        @cancel="metodocancelar(1)"
        @ok="metodook"
      >
        <div slot="modal-title">
          {{ titulomodal1 }} <span class="font-weight-light">Proyecto</span>
          <b-btn
            variant="outline-primary borderless icon-btn"
            class="btn-sm"
            @click="showModal(3, 0)"
            v-if="accionmodal == 2"
            ><i class="ion ion-md-create"></i>
          </b-btn>
        </div>
        <div slot="modal-footer">
          <b-button size="m" variant="danger" @click="metodocancelar(1)">
            Cancelar
          </b-button>
          <b-button
            size="m"
            variant="success"
            v-if="accionmodal != 2"
            @click="metodook(1)"
          >
            Guardar
          </b-button>
          <b-button
            size="m"
            variant="primary"
            @click="metodook(2)"
            v-if="accionmodal == 1"
          >
            Guardar +
          </b-button>
        </div>

        <b-tabs class="nav-tabs-top mb-4">
          <b-tab title="Datos Generales" active>
            <div class="card-body">
              <b-form-row>
                <b-form-group label="Código PUCE" class="col-3">
                  <template>
                    <b-input
                      v-model="CODIGO_PROYECTO"
                      placeholder="Código"
                      :disabled="disablededit"
                      :state="stateCodigo"
                    />
                  </template>
                </b-form-group>
                <b-form-group label="Nombre del Proyecto" class="col-9">
                  <b-input
                    v-model="DESCRIPCION_PROYECTO"
                    placeholder="Nombre del Proyecto (Español)"
                    :disabled="disablededit"
                    :state="stateNombrePro"
                  />
                </b-form-group>
              </b-form-row>
              <b-form-row>
                <b-form-group label="Tipo" class="col-2">
                  <template>
                    <b-select
                      v-model="TIPO_PROYECTO"
                      :disabled="disablededit"
                      :state="tipoProyecto"
                      :options="[
                        { value: '0', text: 'Seleccione...' },
                        { value: '1', text: 'Interno' },
                        { value: '2', text: 'Nacional' },
                        { value: '3', text: 'Internacional' },
                      ]"
                    />
                  </template>
                </b-form-group>
                <b-form-group
                  label="Tipo Interno"
                  class="col-2"
                  v-if="TIPO_PROYECTO == '1'"
                >
                  <template>
                    <b-select
                      value="Seleccione..."
                      v-model="TIPOINTERNO_PROYECTO"
                      :disabled="disablededit"
                      :state="tipoInterno"
                      :options="[
                        { value: '0', text: 'Seleccione...' },
                        { value: '1', text: 'Servicio' },
                        { value: '2', text: 'Investigación' },
                        { value: '3', text: 'Vinculación' },
                      ]"
                    />
                  </template>
                </b-form-group>
                <b-form-group label="Project Name" class="col-8">
                  <b-input
                    v-model="JUSTIFICACION_PROYECTO"
                    placeholder="Nombre del Proyecto (Inglés)"
                    :disabled="disablededit"
                  />
                </b-form-group>
              </b-form-row>

              <b-form-row>
                <b-form-group label="Fecha Inicio" class="col-3">
                  <b-input
                    type="date"
                    v-model="FECHAINICIO_PROYECTO"
                    placeholder="mm/dd/aaaa"
                    :disabled="disablededit"
                    :state="stateFechaInicio"
                  />
                </b-form-group>
                <b-form-group label="Fecha Finalización" class="col-3">
                  <b-input
                    type="date"
                    v-model="FECHAFIN_PROYECTO"
                    placeholder="mm/dd/aaaa"
                    :disabled="disablededit"
                  />
                </b-form-group>
                <b-form-group label="Monto Asignado" class="col-3">
                  <b-input
                    v-model="COSTO_PROYECTO"
                    placeholder="###,##"
                    :disabled="disablededit"
                  />
                </b-form-group>
                <b-form-group label="Estado del Proyecto" class="col-3">
                  <template>
                    <b-select
                      value="Seleccione..."
                      v-model="ESTADO_PROYECTO"
                      :disabled="disablededit"
                      :state="stateEstadoProyecto"
                      :options="[
                        { value: '0', text: 'Seleccione...' },
                        { value: '1', text: 'Activo' },
                        { value: '2', text: 'Finalizado' },
                        { value: '3', text: 'Ejecución' },
                        { value: '4', text: 'Cancelado' },
                        { value: '5', text: 'En Revisión' },
                        { value: '6', text: 'Aprobado' },
                        { value: '7', text: 'No Aprobado' },
                      ]"
                    />
                  </template>
                </b-form-group>
              </b-form-row>
              <b-form-row>
                <b-form-group label="Autorizar" class="col-1">
                  <label class="switcher switcher-success">
                    <input
                      type="checkbox"
                      class="switcher-input"
                      v-model="AUTORIZAR"
                      :disabled="disablededit"
                    />
                    <span class="switcher-indicator">
                      <span class="switcher-yes"
                        ><span class="ion ion-md-checkmark"></span
                      ></span>
                      <span class="switcher-no"
                        ><span class="ion ion-md-close"></span
                      ></span>
                    </span>
                  </label>
                </b-form-group>
                <b-form-group
                  label="Entidad que Autoriza"
                  class="col-7"
                  v-if="AUTORIZAR == 1"
                >
                  <template>
                    <b-select
                      v-model="ENTIDADAUTORIZA"
                      :disabled="disablededit"
                      :state="tipoInterno"
                    >
                      <option value="0">Seleccione...</option>
                      <option
                        v-for="EntidadAutoriza in arrayEntidadAutoriza"
                        :key="EntidadAutoriza.id"
                        :value="EntidadAutoriza.id"
                        v-text="EntidadAutoriza.nombre"
                      ></option>
                    </b-select>
                  </template>
                </b-form-group>
                <b-form-group
                  label="Añadir"
                  class="col-1"
                  v-if="AUTORIZAR == 1"
                >
                  <button
                    type="button"
                    class="btn btn-sm btn-success"
                    @click="showModal(6)"
                  >
                    <span class="ion ion-md-add-circle-outline"></span>
                  </button>
                </b-form-group>

                <b-form-group
                  label="Estado de Autorización"
                  class="col-3"
                  v-if="AUTORIZAR == 1"
                >
                  <template>
                    <b-select
                      value="Seleccione..."
                      v-model="ESTADOAUTORIZA"
                      :disabled="disablededit"
                      :state="stateEstadoProyecto"
                      :options="[
                        { value: '0', text: 'Seleccione...' },
                        { value: '1', text: 'Aprobado' },
                        { value: '2', text: 'Pendiente' },
                        { value: '3', text: 'Rechazado' },
                      ]"
                    />
                  </template>
                </b-form-group>
              </b-form-row>
            </div>
          </b-tab>

          <b-tab title="Financiadores" v-if="accionmodal > 1">
            <div class="card-body">
              <b-form-row>
                <b-form-group label="Financiador" class="col-6">
                  <v-select
                    @search="selectFinanciador"
                    label="NOMBRE"
                    :options="arrayFinanciador"
                    placeholder="Buscar Nombre"
                    v-model="vselectFinanciador"
                    :disabled="disablededit"
                  >
                  </v-select>
                </b-form-group>
                <b-form-group label="Ejecutor" class="col-6">
                  <v-select
                    @search="selectEjecutor"
                    label="NOMBRE"
                    :options="arrayEjecutor"
                    placeholder="Buscar Nombre"
                    v-model="vselectEjecutor"
                    :disabled="disablededit"
                  >
                  </v-select>
                </b-form-group>
              </b-form-row>
            </div>
          </b-tab>

          <b-tab title="Participantes" v-if="accionmodal > 1">
            <div class="card-body">
              <b-form-row>
                <b-form-group label="Director PUCE" class="col-6">
                  <v-select
                    @search="selectDirector"
                    label="NOMBRE"
                    :options="arrayDirector"
                    placeholder="Buscar Nombre"
                    v-model="vselectDirector"
                    :disabled="disablededit"
                  >
                  </v-select>
                </b-form-group>
                <b-form-group label="Director Externo" class="col-6">
                  <v-select
                    @search="selectDirectorExt"
                    label="NOMBRE"
                    :options="arrayDirectorExt"
                    placeholder="Buscar Nombre"
                    v-model="vselectDirectorExt"
                    :disabled="disablededit"
                  >
                  </v-select>
                </b-form-group>
              </b-form-row>
              <b-form-row>
                <b-form-group
                  label="Elegir Investigador/Participante"
                  class="col-11"
                >
                  <v-select
                    @search="selectParticipante"
                    label="NOMBRE"
                    :options="arrayParticipante"
                    placeholder="Buscar Nombre"
                    v-model="vselectParticipante"
                    :disabled="disablededit"
                  >
                  </v-select>
                </b-form-group>
                <b-form-group class="col-1" label="Añadir">
                  <button
                    v-if="arrayParticipante != null"
                    type="button"
                    class="btn btn-sm btn-success"
                    @click="addParticipante()"
                    :disabled="disablededit"
                  >
                    <span class="ion ion-md-add-circle-outline"></span>
                  </button>
                </b-form-group>
              </b-form-row>

              <table class="table table-bordered table-striped table-sm">
                <thead>
                  <tr>
                    <th class="col-2">Nº</th>
                    <th class="col-9">Nombre</th>
                    <th class="col-1">Acción</th>
                  </tr>
                </thead>
                <tbody v-if="arrayListParticipante.length">
                  <tr
                    v-for="detalle in arrayListParticipante"
                    :key="detalle.id"
                  >
                    <td v-text="detalle.id" />
                    <td
                      v-text="
                        detalle.NOMBRES_PERSONAL +
                        ' ' +
                        detalle.APELLIDOS_PERSONAL
                      "
                    />
                    <td>
                      <button
                        :disabled="disablededit"
                        @click="deleteParticipante(detalle.id)"
                        type="button"
                        class="btn btn-danger btn-sm"
                      >
                        <i class="ion ion-md-trash"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td colspan="3">No existen documentos</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </b-tab>

          <b-tab title="Adjuntos" v-if="accionmodal > 1">
            <div class="card-body">
              <b-form-row>
                <b-form-group label="Tipo de Documento" class="col-3">
                  <template>
                    <b-select
                      v-model="tipo_documento"
                      :disabled="disablededit"
                      :state="tipoInterno"
                    >
                      <option value="0">Seleccione...</option>
                      <option
                        v-for="TipoAdjunto in arrayTipoAdjunto"
                        :key="TipoAdjunto.id"
                        :value="TipoAdjunto.id"
                        v-text="TipoAdjunto.descripcion"
                      ></option>
                    </b-select>
                  </template>
                </b-form-group>
                <b-form-group label="Comentario" class="col-9">
                  <b-input
                    v-model="comentarioAdjunto"
                    placeholder="Comentario"
                    :disabled="disablededit"
                  />
                </b-form-group>
                <b-form-row> </b-form-row>
                <b-form-group label="Enlace" class="col-11">
                  <b-input
                    v-model="enlace"
                    placeholder="Enlace"
                    :disabled="disablededit"
                  />
                </b-form-group>
                <b-form-group label="Añadir" class="col-1">
                  <button
                    type="button"
                    class="btn btn-sm btn-success"
                    @click="addAdjunto()"
                    :disabled="disablededit"
                  >
                    <span class="ion ion-md-add-circle-outline"></span>
                  </button>
                </b-form-group>
              </b-form-row>

              <table class="table table-bordered table-striped table-sm">
                <thead>
                  <tr>
                    <th class="col-2">Tipo</th>
                    <th class="col-9">Comentario</th>
                    <th class="col-1">Acción</th>
                  </tr>
                </thead>
                <tbody v-if="arrayAdjunto.length">
                  <tr v-for="detalle in arrayAdjunto" :key="detalle.id">
                    <td v-text="detalle.nombreadjunto" />
                    <td v-text="detalle.descripcion" />
                    <td>
                      <button
                        @click="viewAdjunto(detalle.url)"
                        type="button"
                        class="btn btn-success btn-sm"
                      >
                        <i class="ion ion-md-eye"></i>
                      </button>
                      <button
                        :href="detalle.url"
                        @click="deleteAdjunto(detalle.id)"
                        type="button"
                        class="btn btn-danger btn-sm"
                      >
                        <i class="ion ion-md-trash"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td colspan="3">No existen documentos</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </b-tab>

          <b-tab title="Otros" v-if="accionmodal > 1">
            <div class="row">
              <div class="col-md-6 col-lg-12 col-xl-6">
                <b-card no-body class="mb-4 mt-4">
                  <b-card-header header-tag="h6">Otros Datos</b-card-header>
                  <b-card-body>
                    <b-form-row>
                      <b-form-group label="Total Grant" class="col-12">
                        <b-input
                          v-model="TOTALGRAND"
                          placeholder="Total"
                          :disabled="disablededit"
                        />
                      </b-form-group>
                    </b-form-row>
                  </b-card-body>
                </b-card>
              </div>
              <div class="col-md-6 col-lg-12 col-xl-6">
                <b-card no-body class="mb-4 mt-4">
                  <b-card-header header-tag="h6" class="with-elements">
                    <div class="card-header-title">Presupuesto por Años</div>
                    Saldo:
                    <div class="card-header-elements ml-auto">
                      <b-btn
                        variant="default"
                        class="btn-xs md-btn-flat"
                        :disabled="disablededit"
                        @click="showModal(4, 0)"
                        >Nuevo</b-btn
                      >
                    </div>
                  </b-card-header>
                  <b-card-body>
                    <table class="table table-bordered table-striped table-sm">
                      <thead>
                        <tr>
                          <th class="col-5">Año</th>
                          <th class="col-5">Valor</th>
                          <th class="col-2">Acción</th>
                        </tr>
                      </thead>
                      <tbody v-if="arrayPresupuesto.length">
                        <tr
                          v-for="detalle in arrayPresupuesto"
                          :key="detalle.id"
                        >
                          <td v-text="detalle.anio" />
                          <td v-text="detalle.valor" />
                          <td>
                            <button
                              @click="deletePresupuesto(detalle.id)"
                              type="button"
                              class="btn btn-danger btn-sm"
                            >
                              <i class="ion ion-md-trash"></i>
                            </button>
                          </td>
                        </tr>
                      </tbody>
                      <tbody v-else>
                        <tr>
                          <td colspan="3">No existen Presupuesto</td>
                        </tr>
                      </tbody>
                    </table>
                  </b-card-body>
                </b-card>
              </div>
            </div>
          </b-tab>

          <b-tab title="Comentarios" v-if="accionmodal > 1">
            <div class="card-body">
              <b-form-row>
                <b-form-group label="Comentario" class="col-11">
                  <b-textarea
                    v-model="comentario"
                    placeholder="Comentarios/Observaciones"
                    :disabled="disablededit"
                  />
                </b-form-group>
                <b-form-group label="Añadir" class="col-1">
                  <button
                    type="button"
                    class="btn btn-sm btn-success"
                    @click="addComentario()"
                    :disabled="disablededit"
                  >
                    <span class="ion ion-md-add-circle-outline"></span>
                  </button>
                </b-form-group>
              </b-form-row>

              <table class="table table-bordered table-striped table-sm">
                <thead>
                  <tr>
                    <th class="col-2">Fecha</th>
                    <th class="col-9">Comentario</th>
                    <th class="col-1">Acción</th>
                  </tr>
                </thead>
                <tbody v-if="arrayComentario.length">
                  <tr v-for="detalle in arrayComentario" :key="detalle.id">
                    <td v-text="detalle.created_at" />
                    <td v-text="detalle.comentario" />
                    <td>
                      <button
                        :href="detalle.url"
                        @click="deleteComentario(detalle.id)"
                        type="button"
                        class="btn btn-danger btn-sm"
                      >
                        <i class="ion ion-md-trash"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td colspan="3">No existen Comentarios</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </b-tab>
        </b-tabs>
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
      <!-- Inicio modal Presupuesto -->
      <b-modal
        ref="modal-presupuesto"
        id="modal-presupuesto"
        size="sm"
        cancel-title="Cancelar"
        ok-title="Guardar"
        @cancel="metodocancelar(2)"
        @ok="savePresupuesto"
      >
        <div slot="modal-title">
          Registrar
          <span class="font-weight-light">Presupuesto</span>
        </div>
        <b-form-row>
          <b-form-group label="Año" class="col-12">
            <b-input v-model="presupuesto_anio" placeholder="####" />
          </b-form-group>
        </b-form-row>
        <b-form-row>
          <b-form-group label="Presupuesto" class="col-12">
            <b-input v-model="presupuesto_valor" placeholder="####.##" />
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

      <!-- Inicio modal Entidad -->
      <b-modal
        ref="modal-entidad"
        id="modal-entidad"
        size="sm"
        cancel-title="Cancelar"
        ok-title="Guardar"
        @cancel="metodocancelar(3)"
        @ok="saveEntidad"
      >
        <div slot="modal-title">
          Registrar
          <span class="font-weight-light">Entidad que Autoriza</span>
        </div>
        <b-form-row>
          <b-form-group label="Nombre" class="col-12">
            <b-input v-model="nombreentidad" placeholder="Entidad" />
          </b-form-group>
        </b-form-row>
      </b-modal>
      <!-- fin modal Entidad -->
    </b-card-body>
    <!-- fin modal proyecto -->
  </div>
</template>

<style src="@/vendor/libs/vue-data-tables/vue-data-tables.scss" lang="scss"></style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style src="@/vendor/libs/vue-multiselect/vue-multiselect.scss" lang="scss"></style>


<script>
import Vue from "vue";
import { ClientTable } from "vue-tables-2";
import "vue-select/dist/vue-select.css";

import VueMask from "v-mask";
Vue.use(VueMask);

Vue.use(ClientTable);
import { PaginationPlugin } from "bootstrap-vue";
Vue.use(PaginationPlugin);

import Multiselect from "vue-multiselect";

import vSelect from "vue-select";

import { SweetModal, SweetModalTab } from "sweet-modal-vue";

export default {
  name: "01-Proyecto",
  metaInfo: {
    title: "Proyectos",
  },
  components: {
    Multiselect,
    vSelect,
    SweetModal,
    SweetModalTab,
  },
  data: () => ({
    buscar: "",
    accionmodal: 0,
    accionedit: 0,
    currentPage: 1,
    enlace: "",
    modal: 0,
    error: 0,
    //modal data
    stateCodigo: true,
    stateNombrePro: true,
    stateFechaInicio: true,
    ESTADOAUTORIZA: false,
    ID_PROYECTO: 0,
    ID_PERSONAL: 0,
    ID_FINANCIADOR: 0,
    autorizacion: 0,
    comentario: "",
    CODIGO_PROYECTO: "",
    DESCRIPCION_PROYECTO: "",
    DESCRIPCION_PROYECTO_EN: "",
    FECHAINICIO_PROYECTO: "",
    FECHAFIN_PROYECTO: "",
    JUSTIFICACION_PROYECTO: "",
    ALCANCE_PROYECTO: "",
    COSTO_PROYECTO: null,
    ADJUNTO1_PROYECTO: "",
    ADJUNTO2_PROYECTO: "",
    AUTORIZAR: false,
    ENTIDADAUTORIZA: 0,
    presupuesto_anio: 0,
    presupuesto_valor: 0,
    TOTALGRAND: 0,
    comentarioAdjunto: "",
    nombreentidad: "",
    enlace: "",
    descripcion: "",
    autorización: 0,
    TIPO_PROYECTO: 0,
    TIPOINTERNO_PROYECTO: 0,
    ESTADO_PROYECTO: 0,
    arrayFinanciador: [],
    arrayEjecutor: [],
    arrayTipoAdjunto: [],
    arrayEntidadAutoriza: [],
    arrayDirector: [],
    arrayDirectorExt: [],
    arrayDetalle: [],
    arrayAdjunto: [],
    arrayComentario: [],
    arrayListParticipante: [],
    arrayParticipante: [],
    arrayPresupuesto: [],
    vselectFinanciador: null,
    vselectEjecutor: null,
    vselectDirector: null,
    vselectDirectorExt: null,
    vselectParticipante: null,
    tipo_documento: "",
    titulomodal1: "",
    registro: null,
    //fin modal data-----
    errorPersona: 0,
    errorMostrarMsjPersona: [],
    //table data
    tableData: [],
    columns: [
      "ESTADO_PROYECTO",
      "CODIGO_PROYECTO",
      "DESCRIPCION_PROYECTO",
      "NOMBRE_FINANCIADOR",
      "NOMBRES_PERSONAL",
      "COSTO_PROYECTO",
      "FECHAINICIO_PROYECTO",
      "FECHAFIN_PROYECTO",
      "accion",
    ],
    options: {
      filterable: false,
      headings: {
        ESTADO_PROYECTO: "Estado",
        CODIGO_PROYECTO: "Código",
        DESCRIPCION_PROYECTO: "Nombre del Proyecto",
        NOMBRE_FINANCIADOR: "Financiador",
        NOMBRES_PERSONAL: "Director",
        COSTO_PROYECTO: "Monto",
        FECHAINICIO_PROYECTO: "Fecha de Inicio",
        FECHAFIN_PROYECTO: "Fecha de Fin",
      },
      templates: {
        ESTADO_PROYECTO(h, row) {
          switch (row.ESTADO_PROYECTO) {
            case "1":
              return "Activo";
            case "2":
              return "Finalizado";
            case "3":
              return "Ejecución";
            case "4":
              return "Cancelado";
            case "5":
              return "En Revisión";
            case "6":
              return "Aprobado";
            case "7":
              return "No Aprobado";
            default:
              return "No Definido";
          }
        },
        NOMBRES_PERSONAL(h, row) {
          if (row.NOMBRES_PERSONAL == null) {
            return "No Asignado";
          }
          return row.NOMBRES_PERSONAL + " " + row.APELLIDOS_PERSONAL;
        },
        DESCRIPCION_PROYECTO(h, row) {
          return row.DESCRIPCION_PROYECTO.toUpperCase();
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
    paginacion: {
      total: 0,
      current_page: 0,
      per_page: 0,
      last_page: 0,
      from: 0,
      to: 0,
    },
    icons: {
      beaker: '<i class="ion ion-ios-flask text-big"></i>',
      fork: '<i class="ion ion-md-git-branch text-big"></i>',
      heart: '<i class="ion ion-ios-heart text-big"></i>',
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
    disablededit: function () {
      if (this.accionmodal == 1) {
        return false;
      }
      if (this.accionmodal == 2) {
        return true;
      }
      if (this.accionmodal == 3) {
        return false;
      }
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
    metodocancelar(modal) {
      if (modal == 1) {
        this.borrarDatosModal();
        this.$refs["modal-proyecto"].hide();
      }
      if (modal == 2) {
        this.$refs["modal-presupuesto"].hide();
      }
      if (modal == 3) {
        this.$refs["modal-entidad"].hide();
      }
    },
    selectFinanciador(search, loading) {
      let me = this;
      loading(true);
      var url = "/financiador/selectFinanciador?filtro=" + search;
      axios
        .get(url)
        .then(function (response) {
          let respuesta = response.data;
          q: search;
          me.arrayFinanciador = respuesta.financiadores;
          loading(false);
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },
    selectEjecutor(search, loading) {
      let me = this;
      loading(true);
      var url = "/financiador/selectFinanciador?filtro=" + search;
      axios
        .get(url)
        .then(function (response) {
          let respuesta = response.data;
          q: search;
          me.arrayEjecutor = respuesta.financiadores;
          loading(false);
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },

    selectTipoAdjunto() {
      let me = this;
      var url = "/tipoadjunto/select";
      axios
        .get(url)
        .then(function (response) {
          console.log(response);
          var respuesta = response.data;
          me.arrayTipoAdjunto = respuesta.TipoAdjuntos;
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },

    selectEntidadAutoriza() {
      let me = this;
      var url = "/entidadautoriza/select";
      axios
        .get(url)
        .then(function (response) {
          console.log(response);
          var respuesta = response.data;
          me.arrayEntidadAutoriza = respuesta.Entidades;
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },

    listParticipante() {
      let me = this;
      var url = "/investigador/verRegistro?buscar=" + this.ID_PROYECTO;
      axios
        .get(url)
        .then(function (response) {
          console.log(response);
          var respuesta = response.data;
          me.arrayListParticipante = respuesta.participantes;
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },

    listAdjuntos() {
      let me = this;
      var url = "/adjunto/index?buscar=" + this.ID_PROYECTO;
      axios
        .get(url)
        .then(function (response) {
          console.log(response);
          var respuesta = response.data;
          me.arrayAdjunto = respuesta.adjuntos;
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },

    listComentarios() {
      let me = this;
      var url =
        "/comentario/index?tipo=1&id=" +
        this.ID_PROYECTO;
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

    listPresupuesto() {
      let me = this;
      var url = "/presupuesto/index?buscar=" + this.ID_PROYECTO;
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

    selectDirector(search, loading) {
      let me = this;
      loading(true);
      var url = "/personal/selectPersonal?filtro=" + search;
      axios
        .get(url)
        .then(function (response) {
          let respuesta = response.data;
          q: search;
          me.arrayDirector = respuesta.personales;
          loading(false);
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },

    selectDirectorExt(search, loading) {
      let me = this;
      loading(true);
      var url = "/personal/selectPersonal?filtro=" + search;
      axios
        .get(url)
        .then(function (response) {
          let respuesta = response.data;
          q: search;
          me.arrayDirectorExt = respuesta.personales;
          loading(false);
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },

    selectParticipante(search, loading) {
      let me = this;
      loading(true);
      var url = "/personal/selectPersonal?filtro=" + search;
      axios
        .get(url)
        .then(function (response) {
          let respuesta = response.data;
          q: search;
          me.arrayParticipante = respuesta.personales;
          loading(false);
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },

    addParticipante() {
      let me = this;
      var idinvestigador = this.vselectParticipante.ID_PERSONAL;
      axios
        .post("/investigador/registrar", {
          idproyecto: this.ID_PROYECTO,
          idinvestigador: idinvestigador,
        })
        .then(function (response) {
          me.listParticipante();
          me.arrayParticipante = [];
          me.vselectParticipante = null;
          me.msjform("Correcto", "Grabado exitosamente", "success");
        })
        .catch(function (error) {
          // handle error
          console.log(error);
          me.msjform("Participante ya existe", "No se ha registrado", "danger");
        });
    },

    deleteParticipante(idparticipante) {
      let me = this;
      axios
        .post("/investigador/destroy", {
          id: idparticipante,
        })
        .then(function (response) {
          me.listParticipante();
          me.arrayParticipante = [];
          me.vselectParticipante = null;
          me.msjform("Correcto", "Eliminado exitosamente", "success");
        })
        .catch(function (error) {
          // handle error
          console.log(error);
          me.msjform("No se puede eliminar", "No se ha registrado", "danger");
        });
    },

    deleteAdjunto(idadjunto) {
      let me = this;
      axios
        .post("/adjunto/destroy", {
          id: idadjunto,
        })
        .then(function (response) {
          me.listAdjuntos();
          me.msjform("Correcto", "Eliminado exitosamente", "success");
        })
        .catch(function (error) {
          // handle error
          console.log(error);
          me.msjform("No se puede eliminar", "No se ha registrado", "danger");
        });
    },

    deletePresupuesto(idPresupuesto) {
      let me = this;
      axios
        .post("/presupuesto/destroy", {
          id: idPresupuesto,
        })
        .then(function (response) {
          me.listPresupuesto();
          me.msjform("Correcto", "Eliminado exitosamente", "success");
        })
        .catch(function (error) {
          // handle error
          console.log(error);
          me.msjform("No se puede eliminar", "No se ha registrado", "danger");
        });
    },

    metodook(tipo) {
      if (this.validarRegistro()) {
        return;
      }
      if (this.accionmodal == 1) {
        this.nuevoRegistro();
      }
      if (this.accionmodal == 3) {
        this.actualizarRegistro();
      }
      this.borrarDatosModal();
      if (tipo == 1) {
        this.$refs["modal-proyecto"].hide();
      }
    },

    savePresupuesto() {
      if (this.validarPresupuesto()) {
        return;
      }
      this.addPresupuesto();
      this.$refs["modal-presupuesto"].hide();
    },

    saveEntidad() {
      // if (this.validarEntidad()) {
      //   return;
      // }
      this.addEntidad();
      this.$refs["modal-entidad"].hide();
    },

    validarPresupuesto() {
      return false;
    },

    addPresupuesto() {
      let me = this;
      axios
        .post("/presupuesto/registrar", {
          idproyecto: this.ID_PROYECTO,
          anio: this.presupuesto_anio,
          valor: this.presupuesto_valor,
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

    addEntidad() {
      let me = this;
      axios
        .post("/entidadautoriza/registrar", {
          nombre: this.nombreentidad,
        })
        .then(function (response) {
          me.selectEntidadAutoriza();
          me.ENTIDADAUTORIZA = 0;
          me.msjform("Correcto", "Grabado exitosamente", "success");
        })
        .catch(function (error) {
          // handle error
          console.log(error);
          me.msjform("Participante ya existe", "No se ha registrado", "danger");
        });
    },

    validarRegistro() {
      this.error = 0;
      if (!this.CODIGO_PROYECTO) {
        this.error = 1;
        this.stateCodigo = false;
      }
      return this.error;
    },

    viewAdjunto(url) {
      window.open(url, "_blank");
    },

    addAdjunto() {
      let me = this;
      axios
        .post("/adjunto/registrar", {
          idtipoadjunto: this.tipo_documento,
          idproyecto: this.ID_PROYECTO,
          descripcion: this.comentarioAdjunto,
          url: this.enlace,
        })
        .then(function (response) {
          me.listAdjuntos();
          me.tipo_documento = 0;
          me.comentarioAdjunto = "";
          me.url = "";
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
          idproyecto: this.ID_PROYECTO,
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
    ListarRegistros(page, buscar) {
      let me = this;
      var url = "/proyecto?page=" + page + "&buscar=" + buscar + "&paginate=10";
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
    verRegistro(idregistro) {
      let me = this;
      var url = "/proyecto/verRegistro?buscar=" + idregistro;
      axios
        .get(url)
        .then(function (response) {
          var respuesta = response.data;
          me.registro = respuesta.proyecto;
          me.ID_PROYECTO = me.registro[0]["ID_PROYECTO"];
          me.CODIGO_PROYECTO = me.registro[0]["CODIGO_PROYECTO"];
          me.DESCRIPCION_PROYECTO = me.registro[0]["DESCRIPCION_PROYECTO"];
          me.TIPO_PROYECTO = me.registro[0]["TIPO_PROYECTO"];
          me.TIPOINTERNO_PROYECTO = me.registro[0]["TIPOINTERNO_PROYECTO"];
          me.JUSTIFICACION_PROYECTO = me.registro[0]["JUSTIFICACION_PROYECTO"];
          me.FECHAINICIO_PROYECTO = me.registro[0]["FECHAINICIO_PROYECTO"];
          me.FECHAFIN_PROYECTO = me.registro[0]["FECHAFIN_PROYECTO"];
          me.COSTO_PROYECTO = me.registro[0]["COSTO_PROYECTO"];
          me.ESTADO_PROYECTO = me.registro[0]["ESTADO_PROYECTO"];
          me.AUTORIZAR = me.registro[0]["AUTORIZAR"];
          me.ENTIDADAUTORIZA = me.registro[0]["ENTIDADAUTORIZA"];
          me.ESTADOAUTORIZA = me.registro[0]["ESTADOAUTORIZA"];
          me.TOTALGRAND = me.registro[0]["TOTALGRAND"];
          me.vselectFinanciador = {
            ID_FINANCIADOR: me.registro[0]["ID_FINANCIADOR"],
            NOMBRE: me.registro[0]["NOMBRE_FINANCIADOR"],
          };
          me.vselectEjecutor = {
            ID_FINANCIADOR: me.registro[0]["ID_EJECUTOR"],
            NOMBRE: me.registro[0]["NOMBRE_EJECUTOR"],
          };
          me.vselectDirector = {
            ID_PERSONAL: me.registro[0]["ID_PERSONAL"],
            NOMBRE:
              me.registro[0]["NOMBRES_PERSONAL"] +
              " " +
              me.registro[0]["APELLIDOS_PERSONAL"],
          };
          me.vselectDirectorExt = {
            ID_PERSONAL: me.registro[0]["ID_DIRECTOREXT"],
            NOMBRE:
              me.registro[0]["NOMBRE_DIRECTOREXT"] +
              " " +
              me.registro[0]["APELLIDO_DIRECTOREXT"],
          };
          me.listParticipante();
          me.listAdjuntos();
          me.listPresupuesto();
          me.listComentarios();
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },
    nuevoRegistro() {
      let me = this;
      axios
        .post("/proyecto/registrar", {
          CODIGO_PROYECTO: this.CODIGO_PROYECTO,
          DESCRIPCION_PROYECTO: this.DESCRIPCION_PROYECTO,
          TIPO_PROYECTO: this.TIPO_PROYECTO,
          JUSTIFICACION_PROYECTO: this.JUSTIFICACION_PROYECTO,
          TIPOINTERNO_PROYECTO: this.TIPOINTERNO_PROYECTO,
          FECHAINICIO_PROYECTO: this.FECHAINICIO_PROYECTO,
          FECHAFIN_PROYECTO: this.FECHAFIN_PROYECTO,
          COSTO_PROYECTO: this.COSTO_PROYECTO,
          ESTADO_PROYECTO: this.ESTADO_PROYECTO,
          AUTORIZAR: this.AUTORIZAR,
          ENTIDADAUTORIZA: this.ENTIDADAUTORIZA,
          ESTADOAUTORIZA: this.ESTADOAUTORIZA,
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
          me.msjform("Usuario ya existe", "No se ha registrado", "danger");
        });
    },

    actualizarRegistro() {
      var id_financiador;
      var id_ejecutor;
      var id_director;
      var id_directorext;
      let me = this;

      if (this.vselectFinanciador == null) {
        id_financiador = null;
      } else {
        id_financiador = this.vselectFinanciador.ID_FINANCIADOR;
      }

      if (this.vselectEjecutor == null) {
        id_ejecutor = null;
      } else {
        id_ejecutor = this.vselectEjecutor.ID_FINANCIADOR;
      }

      if (this.vselectDirector == null) {
        id_director = null;
      } else {
        id_director = this.vselectDirector.ID_PERSONAL;
      }

      if (this.vselectDirectorExt == null) {
        id_directorext = null;
      } else {
        id_directorext = this.vselectDirectorExt.ID_PERSONAL;
      }

      axios
        .put("/proyecto/actualizar", {
          ID_PROYECTO: this.ID_PROYECTO,
          ID_FINANCIADOR: id_financiador,
          ID_EJECUTOR: id_ejecutor,
          ID_PERSONAL: id_director,
          ID_DIRECTOREXT: id_directorext,
          CODIGO_PROYECTO: this.CODIGO_PROYECTO,
          DESCRIPCION_PROYECTO: this.DESCRIPCION_PROYECTO,
          TIPO_PROYECTO: this.TIPO_PROYECTO,
          JUSTIFICACION_PROYECTO: this.JUSTIFICACION_PROYECTO,
          TIPOINTERNO_PROYECTO: this.TIPOINTERNO_PROYECTO,
          FECHAINICIO_PROYECTO: this.FECHAINICIO_PROYECTO,
          FECHAFIN_PROYECTO: this.FECHAFIN_PROYECTO,
          COSTO_PROYECTO: this.COSTO_PROYECTO,
          ESTADO_PROYECTO: this.ESTADO_PROYECTO,
          AUTORIZAR: this.AUTORIZAR,
          ENTIDADAUTORIZA: this.ENTIDADAUTORIZA,
          ESTADOAUTORIZA: this.ESTADOAUTORIZA,
          TOTALGRAND: this.TOTALGRAND,
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
    },

    borrarDatosModal() {
      this.ID_PERSONAL = 0;
      this.ID_FINANCIADOR = 0;
      this.CODIGO_PROYECTO = "";
      this.DESCRIPCION_PROYECTO = "";
      this.DESCRIPCION_PROYECTO_EN = "";
      this.FECHAINICIO_PROYECTO = "";
      this.FECHAFIN_PROYECTO = "";
      this.JUSTIFICACION_PROYECTO = "";
      this.ALCANCE_PROYECTO = "";
      this.COSTO_PROYECTO = 0;
      this.ADJUNTO1_PROYECTO = "";
      this.ADJUNTO2_PROYECTO = "";
      this.ESTADO_PROYECTO = 0;
      this.TIPO_PROYECTO = 0;
      this.TIPOINTERNO_PROYECTO = 0;
      this.AUTORIZAR = false;
      this.ENTIDADAUTORIZA = 0;
      this.ESTADOAUTORIZA = 2;
      this.TOTALGRAND = 0;

      this.arrayFinanciador = [];
      this.arrayDirector = [];
      this.arrayDirectorExt = [];
      this.arrayDetalle = [];
      this.vselectFinanciador = null;
      this.vselectEjecutor = null;
      this.vselectDirector = null;
      this.vselectDirectorExt = null;
      this.stateCodigo = true;
      this.tipo_documento = "";
      this.comentario = "";
    },

    borrarDatosModalPresupuesto() {
      this.presupuesto_anio = 0;
      this.presupuesto_valor = 0;
    },

    borrarDatosModalEntidad() {
      this.nombreentidad = "";
    },

    showModal(accion, row) {
      this.selectEntidadAutoriza();
      this.selectTipoAdjunto();
      switch (accion) {
        case 1:
          this.$refs["modal-proyecto"].show();
          this.borrarDatosModal();
          this.accionmodal = 1;
          this.titulomodal1 = "Nuevo";
          this.tituloaccion = "Guardar";
          this.ESTADO_PROYECTO = 1;
          break;
        case 2:
          this.$refs["modal-proyecto"].show();
          this.accionmodal = 2;
          this.titulomodal1 = "Visualizar";
          this.tituloaccion = "Visualizar";
          this.verRegistro(row.ID_PROYECTO);
          break;
        case 3:
          this.accionmodal = 3;
          this.titulomodal1 = "Actualizar";
          this.tituloaccion = "Actualizar";
          this.tipo_documento = 0;
          break;
        case 4:
          this.$refs["modal-presupuesto"].show();
          this.borrarDatosModalPresupuesto();
          break;
        case 5:
          this.$refs["modal-presupuesto"].hide();
          this.borrarDatosModalPresupuesto();
          break;
        case 6:
          this.$refs["modal-entidad"].show();
          this.borrarDatosModalEntidad();
          break;
        case 7:
          this.$refs["modal-entidad"].hide();
          this.borrarDatosModalEntidad();
          break;
      }
    },
  },
  mounted() {
    this.ListarRegistros(1, "");
    //this.selectRol();
  },
};
</script>