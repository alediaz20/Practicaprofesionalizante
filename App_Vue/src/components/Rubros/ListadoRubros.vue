<template>
    <div>

    <a @click="showModalAdd=true">
        Ingresar
    </a>
    <a @click="showSearch=true">
        Buscar
    </a>

    <div class="control" v-if="showSearch">
        <input type="text"  placeholder="Buscar Articulos..." v-model="busqueda" >
        <div class="btn-group">
            <button class="btn btn-outline-danger" @click="showSearch=false;mostrarRubros()">Cerrar</button>
        </div>
    </div>

    <div class="row">
        <div class="contenedor" v-if="showModalAdd">
            <div class="VentanaModal" >
                <div class="cabecera tituloventana">
                    <button class="cierre" @click="altarubro=false">x</button>
                    <h1>Ingresando</h1>
                </div>
                <div class="contenido">
                    <div class="form-group">
                        Nombre <br>
                        <input type="text" autofocus name="nombre" id="nombre" class="form-control" v-model="rubroregistro.nombre">
                    </div>

                    <button class="btn-ghost round green" @click="showModalAdd=false;insertRow()">Ingresar</button>
                    <button class="btn-ghost round red" @click="showModalAdd=false,close">Cancelar</button>
                </div>
            </div>
        </div>
    </div>


    <table class="table table-bordered" width="100%">
    <thead>
    <tr>
    <th class="columna_nombre">
    ID
    </th>
    <th>
    Nombre
    </th>
    <th>
    Acciones
    </th>
    </tr>
    </thead>


    <tbody>
        <tr class="columna_nombre" v-for="(item,index) in busquedaRubros">
            <td>
                {{item.id}}
            </td>
            <td>
                {{item.nombre}}
            </td>

            <td class="btn-container">
                <button class="btn-ghost round yellow" @click="showModalEdit(item)">
                    Editar
                </button>
                <button class="btn-ghost round red" @click="showModalDelete(item)">
                    Eliminar
                </button>
            </td>
        </tr>
    </tbody>
    </table>   

    <div class="contenedor" v-if="modalEditOpen">

    <div class="VentanaModal" >
    <div class="cabecera tituloventana">
    <button class="cierre" @click="modalEditOpen=false;close">x</button>
    <h1>Modificar articulo</h1>
    </div>
    <div class="contenido">
    <div class="form-group">
    Nombre <br>
    <input type="text" name="nombre" id="nombre" class="form-control" v-model="rubroToEdit.nombre">
    </div>
    <div class="form-group">

    </div>
    <button class="btn-ghost primary blue" @click="modalEditOpen=false;modificarRubro()">Editar</button>
    <button class="btn-ghost secundary red" @click="modalEditOpen=false,mostrarRubros()">Cancelar</button>
    </div>
    </div>

    </div>

    <div class="contenedor" v-if="modalDeleteOpen">
        <div class="VentanaModal" >
            <div class="cabecera tituloventana">
                <button class="cierre" @click="modalDeleteOpen=false">x</button>
                <h1>Eliminar</h1>
            </div>
            <div class="contenido">
                    <div class="form-group">
                        Nombre <br>
                        <input readonly type="text" name="nombre" id="nombre" class="form-control" v-model="rowToDelete.nombre">
                        <br>
                        <div class="btn-group">
                        <button class="btn-ghost primary red" @click="modalDeleteOpen=false;deleteRow()">Eliminar</button>
                        <button class="btn-ghost secundary red" @click="modalDeleteOpen=false;close">Cancelar</button>
                        </div>
                    </div>

            </div>
        </div>
    </div>

    </div> 

    

</template>

<script>
import axios from 'axios'
export default {
    name:"ListadoRubros",
    data:function(){
        return{
            listadoRubros:[],
            rubroregistro:[],
                modalEditOpen: false,
                modalDeleteOpen: false,
                showSearch: false,
                showModalAdd: false,
                bajarubro:false,
                mostrarMensaje:false,
                busqueda:"",
                rubroToEdit: {id: null, nombre: ""},
                rowToDelete:  {id: null, nombre: ""},
                
        }
    
    },
    mounted:function(){
       
        this.mostrarRubros();
    },
    
    methods: {
        mostrarRubros:function(){
            const self=this;
            axios.post("http://localhost/agenda/agenda/php/rubros.php")
            .then(function(response){
				if (response.data.rubros===undefined) {
					self.listadoRubros=[];
				} else {
					console.log(response.data.rubros);
					self.listadoRubros=response.data.rubros;
				}
			})
        },
        insertRow:function(){
            const self = this;

			let formdata=new FormData();
			formdata.append("nombre",this.rubroregistro.nombre);

 			axios.post("http://localhost/agenda/agenda/php/altarubro.php",formdata)
			.then(function(response){
				self.mostrarMensaje=false;
				self.mensaje=response.data.mensaje;
	/*
				self.articulos.push({	id:response.data.ultimoId,
                			    		nombre:self.articuloRegistro.nombre});
	*/
				self.mostrarRubros()
			})
        },

        showModalEdit: function(item){
            this.rubroToEdit = item;

            this.modalEditOpen = true;
        },
        
        modificarRubro: function(){

            const self = this;

			let formdata=new FormData();
			formdata.append("id",this.rubroToEdit.id);
			formdata.append("nombre",this.rubroToEdit.nombre);

 			axios.post("http://localhost/agenda/agenda/php/editarrubro.php",formdata)
			.then(function(response){
                self.modalEditOpen = false;
				self.mostrarRubros()
			})

        },

        showModalDelete: function(item)
        {
            this.rowToDelete = item;
            this.modalDeleteOpen = true;
            
        },

        deleteRow: function(){
            const self = this;

			let formdata=new FormData();
			formdata.append("id",this.rowToDelete.id);

 			axios.post("http://localhost/agenda/agenda/php/delete_rubro.php",formdata)
			.then(function(response){
                self.modalDeleteOpen = false;
                self.idToDelete = null;
				self.mostrarRubros()
			})
        }

        

        

    },

    computed:{

        busquedaRubros: function(){
            return this.listadoRubros.filter((item)=> item.nombre.trim().toLowerCase().includes(this.busqueda.trim().toLowerCase()));
        }
        
        
    }




}


</script>


<style>

</style>