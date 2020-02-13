<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    @include('partials.head')
    <meta charset="utf-8">
    <title></title>
  </head>
  <body style="background-color:#cdcdcd">

    <!-- Content Wrapper. Contains page content -->
    <div class="" >
      <!-- Content Header (Page header) -->

      <!-- Main content -->
      <section class="content" >

        <div class="error-page">
          <h2 class="headline text-red">403</h2>

          <div class="error-content">
            <h3><i class="fa fa-warning text-red"></i>Ups! Algo salió mal.-</h3>

            <p>
              {{ $exception->getMessage() }}
              Mientras tanto, puede volver al panel o comunicarse con el Administrador.
            </p>

            <a href="{{ route('expedients.index') }}" class="btn btn-info btn-block">Volver</a>
          </div>
        </div>
        <!-- /.error-page -->

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

  </body>
</html>
