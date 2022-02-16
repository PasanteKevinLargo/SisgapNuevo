@extends('auth.contenido')

@section('login')
 <!-- Content -->

 <div class="authentication-wrapper authentication-3">
    <div class="authentication-inner">

      <!-- Side container -->
      <!-- Do not display the container on extra small, small and medium screens -->
      <div class="d-none d-lg-flex col-lg-8 align-items-center ui-bg-cover ui-bg-overlay-container p-5" style="background-image: url('assets/img/bg/fondo01.jpg');">
        <div class="ui-bg-overlay bg-dark opacity-50"></div>

        <!-- Text -->
        <div class="w-100 text-white px-5">
          <h1 class="display-2 font-weight-bolder mb-4">
            CISeAL<br><br>
             CENTRO DE INVESTIGACIÓN PARA LA SALUD EN AMÉRICA LATINA</h1>
          <div class="text-large font-weight-light">
            CENTER FOR RESEARCH ON HEALTH IN LATIN AMERICA
          </div>
        </div>
        <!-- /.Text -->
      </div>
      <!-- / Side container -->

      <!-- Form container -->
      <div class="theme-bg-white d-flex col-lg-4 align-items-center p-5">
        <!-- Inner container -->
        <!-- Have to add `.d-flex` to control width via `.col-*` classes -->
        <div class="d-flex col-sm-7 col-md-5 col-lg-12 px-0 px-xl-4 mx-auto">
          <div class="w-100">

            <!-- Logo -->
            <img src="assets/img/bg/logociceal.jpg" alt="MAIN DATA SISTEMAS" style="width:350px;height:180px;">
            <!-- / Logo -->

            <h4 class="text-center text-lighter font-weight-normal mt-5 mb-0">Ingresa a tu cuenta</h4>

            <!-- Form -->
            <form class="my-5 was-validated" method="POST" action="{{route('login')}}">
             {{csrf_field() }}  
              <div class="form-group {{$errors->has('usuario' ? 'is-invalid' : '')}}">
                <label class="form-label">Usuario</label>
                <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Usuario">
                {!!$errors->first('usuario','<span class="invalid-feedback">:message</span>')!!}
              </div>
              <div class="form-group {{$errors->has('password' ? 'is-invalid' : '')}}">
                <label class="form-label d-flex justify-content-between align-items-end">
                  <div>Contraseña</div>
                  <!-- <a href="javascript:void(0)" class="d-block small">Forgot password?</a> -->
                </label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                {!!$errors->first('password','<span class="invalid-feedback">:message</span>')!!}
              </div>
              <div class="d-flex justify-content-between align-items-center m-0">
                <label class="custom-control custom-checkbox m-0">
                  <input type="checkbox" class="custom-control-input">
                  <span class="custom-control-label">Recordarme</span>
                </label>
                <button type="submit" class="btn btn-primary">Ingresar</button>
              </div>
            </form>
            <!-- / Form -->

            <div class="text-center text-muted">
              No puedes ingresar a tu cuenta? <a href="javascript:void(0)">Contáctanos</a>
            </div>

          </div>
        </div>
      </div>
      <!-- / Form container -->

    </div>
  </div>

  <!-- / Content -->
@endsection
