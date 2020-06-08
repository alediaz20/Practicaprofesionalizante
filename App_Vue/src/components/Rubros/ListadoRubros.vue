<template>
    <div>

    <a @click="altarubro=true">
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			Ingresar
		</a>
		<a @click="buscarRubros=true">
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			Buscar
		</a>
		
		<div class="control" v-if="buscarRubros">
				<input type="text"  placeholder="Buscar Articulos..." v-model="busqueda" >
				<div class="btn-group">
				<button class="btn btn-outline-danger" @click="buscarRubros=false;mostrarRubros()">Cerrar</button>
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
                        <button class="btn-ghost round yellow" @click="editararticulos=true,cargaArticulo(articulo)">
                            Editar
                        </button>
                        <button class="btn-ghost round red" @click="bajaarticulo=true,cargaArticulo(articulo)">
                            Eliminar
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>   
        
    </div>    
</template>

<script>
import axios from 'axios'
export default {
    name:"ListadoRubros",
    data:function(){
        return{
            listadoRubros:[],

                altarubro:false,
                bajarubro:false,
                editarrubro:false,
                mostrarMensaje:false,
                busqueda:"",
                buscarRubros: false,
                
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