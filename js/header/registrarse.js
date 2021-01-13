var registrarse_vue = new Vue({
	el:"#registrarse-modal",
	data:{
		usuario:'',
		clave:'',
		repetir_clave:''
	},
	computed:{
		revisar_usuario:function(){
			if (this.usuario.length != 0 && this.usuario.length >= 4 && this.usuario.length <= 20) {
				return 'form-control is-valid';
			}
			if (this.usuario.length == 0) {
				return 'form-control';
			}
			if (this.usuario.length > 0 && this.usuario.length < 4) {
				return 'form-control is-invalid';
			}
			if (this.usuario.length > 20) {
				return 'form-control is-invalid';
			}
		},
		revisar_clave:function(){
			if (this.clave.length != 0) {
				if (this.clave == this.repetir_clave) {
					return 'form-control is-valid'
				}else{
					return 'form-control';
				}
			}else{
				return 'form-control';
			}
		}
	}
})