<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="css/bootstrap.min.css" ></script>
	<script src="js/axios.js"></script>
	<script src="js/vue.js"></script>


	<link   rel="stylesheet" href="css/propio.css" ></script>
</head>
<body class="Body1">


	<div id="app" class="container">
		<div class="row">
			<div class="col-lg-5 col-md-8 col-sm-7 col-xs-6">
				<div class="form-group">
					<div class="titulo"> <h1>{{titulo}}</h1> </div>
					<div v-if="mostrarMensaje" class="mensaje"> {{mensaje}}
						<button class="cierre" @click="mostrarMensaje=false">x</button>
					</div>
				</div>
				<br>
				<br>
				<div>
				<button class="btn-ghost round green" @click="altaarticulo=true">Ingresar</button>
				<button class="btn-ghost round blue" @click="buscararticulo=true">Buscar</button>
				</div>
				<div class="control" v-if="buscararticulo">
				        <input type="text"  placeholder="Buscar articulos..." v-model="busqueda" >
				          <div class="btn-group">
				          <button class="btn btn-outline-danger" @click="buscararticulo=false,mostrarArticulos()">Cerrar</button>
				          </div>
				        </div>



				<table class="table table-bordered">
					<thead>
						<tr>
							<th class="columna_nombre">
								Nombre
							</th>
							<th>
				                Rubro
				            </th>
							<th>
								Acciones
							</th>

						</tr>
					</thead>
						<tr class="columna_nombre" v-for="(articulo,index) in buscarArticulos">
							<td>
								{{articulo.nombre}}
							</td>
							<td>
				                {{articulo.rubro_nombre}}
				            </td>

							<td class="btn-container">
								<button class="btn-ghost round yellow" @click="editararticulos=true,cargaArticulo(articulo)">
									Editar
								</button>
								<button class="btn-ghost round red" @click="bajaarticulo=true,cargaArticulo(articulo)">
									Eliminar
								</button>
							</td>
						</tr>
					<tbody>

					</tbody>
				</table>

			</div>

			<div class="col-lg-7  col-md-4 col-sm-5 col-xs-6">
				{{ $data }}
     		</div>

		</div>


		<div class="row">
			<div class="contenedor" v-if="altaarticulo">
				<div class="VentanaModal" >
					<div class="cabecera tituloventana">
						<button class="cierre" @click="altaarticulo=false">x</button>
						<h1>Ingresando</h1>
					</div>
					<div class="contenido">
							<div class="form-group">
								Nombre <br>
								<input type="text" autofocus name="nombre" id="nombre" class="form-control" v-model="articuloRegistro.nombre">
							</div>
							<div class="form-group">
								Rubro <br>
								<select name="id_rubro" id="id_rubro" class="form-control" v-model="articuloRegistro.id_rubro">
									<option value=""> Seleccionar rubro </option>
									<option v-for="item in rubros" :value="item.id"> {{item.nombre}} </option>
								</select>
							</div>
							<button class="btn-ghost round green" @click="altaarticulo=false;ingresarArticulos()">Ingresar</button>
							<button class="btn-ghost round red" @click="altaarticulo=false,close">Cancelar</button>
					</div>
				</div>
			</div>

			<div class="contenedor" v-if="editararticulos">

			<div class="VentanaModal" >
				<div class="cabecera tituloventana">
					<button class="cierre" @click="editararticulos=false;close">x</button>
					<h1>Modificar articulo</h1>
				</div>
				<div class="contenido">
						<div class="form-group">
							Nombre <br>
							<input type="text" name="nombre" id="nombre" class="form-control" v-model="articuloRegistro.nombre">
						</div>
						<div class="form-group">
							Rubro <br>
				                <select name="id_rubro" id="id_rubro"  class="form-control" v-model="articuloRegistro.id_rubro">
						                <option value="">Seleccionar rubro</option>
						                <option v-for="item in rubros" :value="item.id">{{item.nombre}}</option>
				                </select>
						</div>
						<button class="btn-ghost primary blue" @click="editararticulos=false;modificarArticulos()">Editar</button>
						<button class="btn-ghost secundary red" @click="editararticulos=false,mostrarArticulos()">Cancelar</button>
				</div>
			</div>

 			</div>

			<div class="contenedor" v-if="bajaarticulo">
				<div class="VentanaModal" >
					<div class="cabecera tituloventana">
						<button class="cierre" @click="bajaarticulo=false">x</button>
						<h1>Eliminar</h1>
					</div>
					<div class="contenido">
							<div class="form-group">
								Nombre <br>
								<input readonly type="text" name="nombre" id="nombre" class="form-control" v-model="articuloRegistro.nombre">
								<br>
								<div class="btn-group">
								<button class="btn-ghost primary red" @click="bajaarticulo=false;eliminarArticulos()">Eliminar</button>
								<button class="btn-ghost secundary red" @click="bajaarticulo=false;close">Cancelar</button>
								</div>
							</div>

					</div>
				</div>
 			</div>


		</div>





	</div>
</body>

<script src="js/app.js"></script>
</html>