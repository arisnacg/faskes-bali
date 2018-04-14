<template>
	<div>
		<form @submit.prevent="generate">
			<h1><b style="color: #5ebea9; margin-right: 2px">QRCODE</b> GENERATOR</h1>
			<div class="row">
				<div class="col-sm-12 col-md-7">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">Kode</div>
							<input type="text" :value="qrcode.instansi.toUpperCase()+'/'+qrcode.pemerintah.toUpperCase()+'/'+qrcode.tahun+'/'+qrcode.min+'-'+qrcode.max" class="form-control" disabled>
						</div>
					</div>
					<div class="qrcode-data-form">
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Instansi</label>
							<div class="col-sm-8">
								<input type="text" v-model="qrcode.instansi" class="form-control" style="text-transform: uppercase">
								<small class="error-control" v-if="error.instansi">{{error.instansi[0]}}</small>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Pemerintah</label>
							<div class="col-sm-8">
								<input type="text" v-model="qrcode.pemerintah" class="form-control" style="text-transform: uppercase">
								<small class="error-control" v-if="error.pemerintah">{{error.pemerintah[0]}}</small>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Tahun</label>
							<div class="col-sm-8">
								<input type="text" v-model="qrcode.tahun" class="form-control">
								<small class="error-control" v-if="error.tahun">{{error.tahun[0]}}</small>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Seri</label>
							<div class="col-sm-8 row">
								<div class="col-sm-5">
									<input type="text" v-model="qrcode.min" class="form-control">
								</div>
								-
								<div class="col-sm-5">
									<input type="text" v-model="qrcode.max" class="form-control">
								</div>
								<small class="error-control" v-if="error.min">{{error.min[0]}}</small>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-12 col-md-5">
		    			<img class="img-qrcode" src="/images/qrcode.png">
		    			<center>
		    				<button type="submit" class="btn btn-success" :disabled="isProcessing">
		    					<span class="fa fa-download"></span> Download
		    				</button>
		    			</center>
		    	</div>
			</div>
		</form>
	</div>
	
</template>

<script>
	
export default {
	data(){
		return {
			qrcode: {
				instansi: "",
				pemerintah: "",
				tahun: "",
				min: "",
				max: ""
			},
			error: {},
			isProcessing: false
		}
	}, 
	methods: {
		generate(){
			this.isProcessing = true
			axios.post('/qrcode', this.qrcode).then((res) => {
				if(res.data.generated){
					const file = res.data.filename
					axios.get('/download/'+res.data.filename, {responseType: 'arraybuffer'}).then((res) => {
						const url = window.URL.createObjectURL(new Blob([res.data], { type: 'application/pdf'}))
						const link = document.createElement('a')
						link.href = url
						link.download = file
						link.click()
						this.isProcessing = false
					})
					this.isProcessing = false
				}
			}).catch((err) => {
				this.error = err.response.data
				console.log(err)
			})
			return false;
		}
	}
}

</script>