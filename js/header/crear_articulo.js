var crear_articulo_vue = new Vue({
	el:"#crear-articulo-modal",
	data:{
		imagen:'https://www.redeszone.net/app/uploads-redeszone.net/2019/06/subir-archivos-sin-registro-800x388.jpg',
		error_imagen:'',
		contenido:''
	},
	methods:{
		cambiar_imagen:function(e){
			nombre = e.target.files[0].name;
			extension = nombre.substr(nombre.length-3, nombre.length);
			if (extension == 'jpg' || extension == 'png') {
				this.error_imagen = '';
				this.imagen = URL.createObjectURL(e.target.files[0]);
			}else{
				this.error_imagen = 'Solo se admiten jpg, png';
			}
		}
	}
})