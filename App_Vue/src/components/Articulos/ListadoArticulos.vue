<template>
    <div>
		<a @click="altaarticulo=true">
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			Ingresar
		</a>
		<a @click="showMostrador=true">
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			Buscar
		</a>
		
		<div class="control" v-if="showMostrador">
				<input type="text"  placeholder="Buscar Articulos..." v-model="busqueda" >
				<div class="btn-group">
				<button class="btn btn-outline-danger" @click="showMostrador=false;mostrarArticulos()">Cerrar</button>
			</div>
		</div>
		


    
        <table class="table table-bordered" width="100%">
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
</template>

<script>

import axios from 'axios'

    export default{
        name: "Listado",
        data: function(){

            return {
                titulo:"Stock",
                articulos:[],
                rubros:[],

                articuloRegistro:[],
                mensaje:'',
                busqueda:'',
                indice:0,

                altaarticulo:false,
                bajaarticulo:false,
                editararticulos:false,
                mostrarMensaje:false,
                buscararticulo:false,
				altarubro:false,
				showMostrador: false
            }
        },

        mounted:function(){
		this.mostrarArticulos();
		this.mostrarRubros();
	},


	methods:{
		mostrarArticulos:function(){

            const self = this;

        
			axios.post("http://localhost/agenda/agenda/php/listar.php")
			.then(function(response){
				if (response.data.articulos===undefined) {
					self.articulos=[];
				} else {
					console.log(response.data.articulos);
					self.articulos=response.data.articulos;
				}
			})
		},

		mostrarRubros:function(){
            
            const self = this;

			axios.get("http://localhost/agenda/agenda/php/rubros.php")
			.then(function(response){
				if (response.data.rubros===undefined) {
					self.rubros=[];
				} else {
					console.log("LISTANDO RUBROS");
					console.log(response.data.rubros);
					self.rubros=response.data.rubros;
				}
			})
		},



		ingresarArticulos:function(){

            
            const self = this;

			let formdata=new FormData();
			formdata.append("nombre",this.articuloRegistro.nombre);
			formdata.append("id_rubro",this.articuloRegistro.id_rubro);

 			axios.post("http://localhost/agenda/agenda/php/ingresar.php",formdata)
			.then(function(response){
				self.mostrarMensaje=false;
				self.mensaje=response.data.mensaje;
	/*
				self.articulos.push({	id:response.data.ultimoId,
                			    		nombre:self.articuloRegistro.nombre});
	*/
				self.mostrarArticulos()
			})
		},
	cargaArticulo:function(dato){
      console.log(dato);
      this.articuloRegistro=dato;
    },


		modificarArticulos:function(){

            
            const self = this;

			let formdata=new FormData();
			formdata.append("id",this.articuloRegistro.id);
			formdata.append("nombre",this.articuloRegistro.nombre);
			formdata.append("id_rubro",this.articuloRegistro.id_rubro);
console.log(this.articuloRegistro);
 			axios.post("http://localhost/agenda/agenda/php/editar.php",formdata)
			.then(function(response){
				self.mostrarMensaje=false;
				self.mensaje=response.data.mensaje;
	/*
				self.articulos.push({	id:response.data.ultimoId,
                			    		nombre:self.articuloRegistro.nombre});
	*/
				self.mostrarArticulos();
			})
		},




		eliminarArticulos:function(){
            
            const self = this;

			let formdata=new FormData();
			formdata.append("id",this.articuloRegistro.id);
		//	formdata.append("nombre",this.articuloRegistro.nombre);

 			axios.post("http://localhost/agenda/agenda/php/eliminar.php",formdata)
			.then(function(response){
				self.mostrarMensaje=false;
				self.mensaje=response.data.mensaje;
	/*
				self.articulos.push({	id:response.data.ultimoId,
                			    		nombre:self.articuloRegistro.nombre});
	*/
				self.mostrarArticulos();
			})
		},


	},

	computed:{

		buscarArticulos: function(){
				return this.articulos.filter((articulo)=>articulo.nombre.trim().toLowerCase().includes(this.busqueda.trim().toLowerCase()))
		},
	}

    }
</script>

<style>

</style>