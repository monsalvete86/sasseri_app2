@extends('auth.contenido')

@section('login')
<div class="row justify-content-center">
      <div class="col-xl-5 col-lg-4 col-md-6">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card p-4 login-form">
          <form class="form-horizontal was-validated" method="POST" action="{{ route('login')}}">
          {{ csrf_field() }}
              <div class="card-body">
              <h1 class="text-center">Acceder</h1>
              <!-- <div class="text-center">
                <img style="width:200px" src="img/logo.png" alt="Sasseri"/>
              </div> -->
              <p class="text-muted">Control de acceso al sistema</p>

              <div class="input-group form-group input-group-joined {{$errors->has('usuario' ? 'is-invalid' : '')}}">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="icon-user"></i>
                  </span>                  
                </div>
                <input class="form-control" type="text" value="{{old('usuario')}}" name="usuario" id="usuario" placeholder="Usuario">
                  {!!$errors->first('usuario','<span class="invalid-feedback">:message</span>')!!}
              </div>

              <div class="input-group form-group input-group-joined {{$errors->has('password' ? 'is-invalid' : '')}}">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="icon-lock"></i>
                  </span>                  
                </div>
                <input  type="password" name="password" id="password" placeholder="Password" class="form-control">
                  {!!$errors->first('password','<span class="invalid-feedback">:message</span>')!!}
              </div>

              <div class="row">
                <div class="col-12 text-center">
                  <button type="submit" class="btn btn-success px-4">Acceder</button>
                </div>
              </div>
            </div>
          </form>
          </div>
          
        </div>
      </div>
    </div>
@endsection
