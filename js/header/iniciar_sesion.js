var iniciar_sesion_vue = new Vue({
	el:"#iniciar-sesion-modal",
	data:{
		usuario:'',
		clave:''
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
			if (this.clave.length != 0 && this.clave.length >= 4 && this.clave.length <= 20) {
				return 'form-control is-valid';
			}
			if (this.clave.length == 0) {
				return 'form-control';
			}
			if (this.clave.length > 0 && this.clave.length < 4) {
				return 'form-control is-invalid';
			}
			if (this.clave.length > 20) {
				return 'form-control is-invalid';
			}
		}
	}
})