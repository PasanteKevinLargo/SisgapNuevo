<template>
  <b-navbar toggleable="lg" :variant="getLayoutNavbarBg()" class="layout-navbar align-items-lg-center container-p-x">

    <!-- Brand -->
    <b-navbar-brand to="/">SISGAP</b-navbar-brand>

    <!-- Sidenav toggle -->
    <b-navbar-nav class="align-items-lg-center mr-auto mr-lg-4" v-if="sidenavToggle">
      <a class="nav-item nav-link px-0 ml-2 ml-lg-0" href="javascript:void(0)" @click="toggleSidenav">
        <i class="ion ion-md-menu text-large align-middle" />
      </a>
    </b-navbar-nav>

    <!-- Navbar toggle -->
    <b-navbar-toggle target="app-layout-navbar"></b-navbar-toggle>

    <b-collapse is-nav id="app-layout-navbar">
      <b-navbar-nav class="align-items-lg-center">
        <b-nav-item href="http://www.main-data.net/" target="_blank">PUCE</b-nav-item>
        <b-nav-item href="http://www.main-data.net/megued/" target="_blank">SISGAP</b-nav-item>
      </b-navbar-nav>
    </b-collapse>
    <div class="nav-item d-none d-lg-block text-big font-weight-light line-height-1 opacity-25 mr-3 ml-1">|</div>

        <b-nav-item-dropdown :right="!isRtlMode" class="demo-navbar-user">
          <template slot="button-content">
            <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
              <span class="px-1 mr-lg-2 ml-2 ml-lg-0">{{nombreUsuario}}</span>
            </span>
          </template>

          <b-dd-item @click="datosusuario()"><i class="ion ion-ios-person text-lightest"></i> &nbsp; Mis Datos</b-dd-item>
          <b-dd-divider />
          <!-- <b-dd-item><router-link v-on:click="doSomethingCool" to="/logout">Salir</router-link></b-dd-item> -->
          <b-dd-item @click="logOut()"><i class="ion ion-md-settings text-lightest"></i> &nbsp; Salir</b-dd-item>
        </b-nav-item-dropdown>

  </b-navbar>
</template>

<script>

export default {

  
  name: 'app-layout-navbar',

  data: () => ({
      idrol:0,
      nombreUsuario:'',
      respuestacontroler:'',
    }),
  props: {
    sidenavToggle: {
      type: Boolean,
      default: true
    }
  },

  methods: {
    getPerfilUsuario(){
        let me=this;
        var url= '/user/getPerfilUsuario';
        axios.get(url).then(function (response) {
            console.log(response);
            var respuesta=response.data;
            me.nombreUsuario = respuesta.nombreusuario;
        })
        .catch(function (error) {
            // handle error
            console.log(error);
        });
    },
    logOut(){
        let me=this;        
        var url= '/logout';
        axios.post(url).then(function (response) {
            console.log(response);
            window.location.href = '/';
            // var respuesta=response.data;
            // this.respuestacontroler = respuesta;


        })
        .catch(function (error) {
            // handle error
            console.log(error);
        });
    },

    toggleSidenav () {
      this.layoutHelpers.toggleCollapsed()
    },

    datosusuario () {
      this.$router.push('datos');
    },

    getLayoutNavbarBg () {
      return this.layoutNavbarBg
    }
  },
  mounted() {
            this.getPerfilUsuario();
        }
}
</script>
