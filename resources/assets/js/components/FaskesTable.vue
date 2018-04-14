<template>
  <div>
	<!-- memilih kontrak -->
    <div class="select-contract">
    	<div class="form-group col-sm-12 col-md-4">
    		<label class="form-label">Kode Kontrak</label>
    		<select class="form-control" v-model="idContract" @change="selectContract">
    			<option value="empty" disabled selected>- Daftar Kontrak -</option>
    			<option v-for="contract in contracts" :value="contract.id">{{ contract.code }}</option>
    		</select>
    	</div>
    	<div class="gray-border" v-if="idContract != 'empty'">
    		<div class="row">
    			<div class="col-sm-12 col-md-6">
    				<div class="row contract-info">
    					<label class="col-sm-12 col-md-4">Kode Kontrak</label>
    					<span class="col-sm-12 col-md-6"> {{ selectedContract.code }}</span>
    				</div>
    				<div class="row contract-info">
    					<label class="col-sm-12 col-md-4">Nilai Kontrak</label>
    					<span class="col-sm-12 col-md-6"> Rp. {{ selectedContract.value }}</span>
    				</div>
    				<div class="row contract-info">
    					<label class="col-sm-12 col-md-4">Tahun</label>
    					<span class="col-sm-12 col-md-6"> {{ selectedContract.year }}</span>
    				</div>
    			</div>
    			<div class="col-sm-12 col-md-6">
    				<div class="row contract-info">
    					<label class="col-sm-3">Konsultan</label>
    					<span class="col-sm-8">{{ selectedContract.consultant.name }}</span>
    				</div>
    				<div class="row contract-info">
    					<label class="col-sm-3">Kontraktor</label>
    					<span class="col-sm-8">{{ selectedContract.contractor.name }}</span>
    				</div>
    				<div class="row contract-info">
    					<label class="col-sm-3">PPK</label>
    					<span class="col-sm-8">{{ selectedContract.ppk.name }}</span>
    				</div>
    				<div class="row contract-info">
    					<label class="col-sm-3">PPTK</label>
    					<span class="col-sm-8">{{ selectedContract.pptk.name }}</span>
    				</div>
    			</div>
    		</div>	
    	</div>
    </div>
    <table class="table table-stripped table-responsive" id="table">
    	<thead>
    		<tr>
    			<th>No</th>
    			<th>Kode</th>
    			<th>Kondisi</th>
    			<th>Jenis</th>
    			<th>Operasi</th>
    		</tr>
    	</thead>
    	<tbody>
    		<tr v-for="(facility, i) in facilities" v-if="facility.contract_id == idContract">
    			<td>{{ i + 1 }}</td>
    			<td>{{ facility.code }}</td>
    			<td>{{ facility.condition.name }}</td>
    			<td>{{ facility.type.name }}</td>
    			<td>
    				<button class="btn btn-primary" @click="viewRow(facility)">
            			<span class="fa fa-eye"></span>
            		</button>
	            	<button class="btn btn-danger" @click="destroy(facility)">
	            		<span class="fa fa-trash"></span>
	            	</button>
    			</td>
    		</tr>
    	</tbody>
    </table>
	<!-- btn float -->
  	<div class="float-btn" v-show="idContract != 'empty'">
		<a @click.prevent="createRow"  class="btn-success"><span class="fa fa-plus"></span></a>
	</div>

	<!-- modal view -->
	<div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Detail Fasilitas</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form @submit.prevent="store">
					<div class="modal-body">
						<div class="form-group">
							<label class="form-label">Kode Fasilitas</label>
							<input type="text" class="form-control" v-model="viewForm.code" disabled>
						</div>
						<div class="form-group">
							<label class="form-label">Latitude</label>
							<input type="text" class="form-control" v-model="viewForm.latitude" disabled>
						</div>
						<div class="form-group">
							<label class="form-label">Longtude</label>
							<input type="text" class="form-control" v-model="viewForm.longitude" disabled>
						</div>
						<div class="form-group">
							<label class="form-label">Jenis Fasilitas</label>
							<select class="form-control" v-model="viewForm.facility_type_id" disabled>
								<option value="empty" disabled>-- Daftar Fasilitas --</option>
								<option v-for="(facility_type, i) in facility_types" :value="facility_type.id">
									{{facility_type.name}}
								</option>
							</select>
						</div>
						<div class="form-group" v-if="viewForm.facility_type_id==2">
							<label class="form-label" style="display: block">Jenis Rambu</label>
							<img :src="viewForm.traffic_sign[0].src" width="80px" height="80px">
						</div>
						<div class="form-group">
							<label class="form-label">Volume</label>
							<input type="text" class="form-control" v-model="viewForm.volume" disabled>
						</div>
						<div class="form-group">
							<label class="form-label">Kondisi Fasilitas</label>
							<select class="form-control" v-model="viewForm.condition_id" disabled>
								<option v-for="(condition, i) in conditions" :value="condition.id">
									{{condition.name}}
								</option>
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<button :disabled="isProcessing" type="submit" class="btn btn-success"><span class="fa fa-save"></span> Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- modal create -->
	<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Fasilitas Baru</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form @submit.prevent="store">
					<div class="modal-body">
						<div class="form-group">
							<label class="form-label">Kode Fasilitas</label>
							<input type="text" class="form-control" v-model="createForm.code">
							<small class="error-control" v-if="error.code">{{error.code[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">Latitude</label>
							<input type="text" class="form-control" v-model="createForm.latitude">
							<small class="error-control" v-if="error.latitude">{{error.latitude[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">Longtude</label>
							<input type="text" class="form-control" v-model="createForm.longitude">
							<small class="error-control" v-if="error.longitude">{{error.longitude[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">Jenis Fasilitas</label>
							<select class="form-control" v-model="createForm.facility_type_id">
								<option value="empty" disabled>-- Daftar Fasilitas --</option>
								<option v-for="(facility_type, i) in facility_types" :value="facility_type.id">
									{{facility_type.name}}
								</option>
							</select>
							<small class="error-control" v-if="error.facility_type_id">{{error.facility_type_id[0]}}</small>
						</div>
						<div class="form-group" v-show="createForm.facility_type_id===2">
							<label class="form-label">Jenis Rambu</label>
							<select class="form-control" v-model="traffic_sign_type_id">
								<option value="" disabled>-- Daftar Tabel Rambu --</option>
								<option v-for="(data, i) in traffic_sign_types" :value="data.id">
									{{data.name}}
								</option>
							</select>
							<small class="error-control" v-if="error.facility_type_id">{{error.facility_type_id[0]}}</small>
						</div>
						<div class="form-group" v-show="traffic_sign_type_id">
							<label class="form-label">Pilih Rambu</label>
								<ImageSelect :dataImages="selectedTraffic"
								            @onselectimage="onSelectImage">
								</ImageSelect>
						</div>
						<div class="form-group">
							<label class="form-label">Volume</label>
							<input type="text" class="form-control" v-model="createForm.volume">
							<small class="error-control" v-if="error.volume">{{error.volume[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">Kondisi Fasilitas</label>
							<select class="form-control" v-model="createForm.condition_id">
								<option v-for="(condition, i) in conditions" :value="condition.id">
									{{condition.name}}
								</option>
							</select>
							<small class="error-control" v-if="error.condition_id">{{error.condition_id[0]}}</small>
						</div>
					</div>
					<div class="modal-footer">
						<button :disabled="isProcessing" type="submit" class="btn btn-success"><span class="fa fa-save"></span> Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>

  </div> 

</template>

<script>
import ImageSelect from './ImageSelect.vue'
require('vue-select-image/dist/vue-select-image.css')
  
export default {
	components: {
		ImageSelect
	},
	data(){
		return {
			gambar: 0,
			isProcessing: false,
			facilities: [],
			facility_types: [],
			contracts: [],
			conditions: [],
			traffic_sign_types: [],
			traffic_sign_type_id: "",
			idContract: "empty",
			selectedContract: {},
			viewForm: {
				traffic_sign: [
					{name: ''}
				]
			},
			editForm: {},
			createForm: {
				contract_id: "empty",
				facility_type_id: 1,
				condition_id: 1,
				traffic_sign_id: "empty"
			},
			types: ["Kontraktor", "Konsultan"],
			error: {},
			imageSelected: {
			    id: '',
			    src: '',
			    traffic_sign_type_id: ''
			 },
			 traffic_signs: [],
			 selectedTraffic: []
		}
	},
	created(){
		axios.get(`/facility`).then((res) => {
			this.facilities = res.data.facilities
			this.facility_types = res.data.facility_types
			this.conditions = res.data.conditions
			this.traffic_signs = res.data.traffic_signs
			this.selectedTraffic = this.traffic_signs
			this.traffic_sign_types = res.data.traffic_sign_types
		}).catch((err) => {
			console.log(err)
		})

		axios.get(`/contract`).then((res) => {
			this.contracts = res.data.contracts
		}).catch((err) => {
			console.log(err)
		})                                                    
	},
	methods: {
		viewRow(data){
			this.viewForm = Object.assign({}, data)
			if(data.traffic_sign){
				this.imageSelected = Object.assign({}, data.traffic_sign[0])
				delete this.imageSelected.pivot
			} else {
				delete this.viewForm.traffic_sign
			}
			$("#modalView").modal()
		},
		editRow(data){
			this.editForm = Object.assign({}, data)
			$("#modalEdit").modal()
		},
		update(){
			this.isProcessing = true
			axios.put('/partner/'+this.editForm.id, this.editForm).then((res) => {
				if(res.data.updated){
					$("#modalEdit").modal('hide')
					swal({
						title: "Sukses",
						text: res.data.msg,
						icon: "success",
						button: false,
						timer: 1200
					})
					const i = this.partners.findIndex(x => x.id==this.editForm.id);
					this.partners[i] = Object.assign({}, this.editForm)
				}
				this.isProcessing = false
			}).catch((err) => {
				this.error = err.response.data;
				this.isProcessing = false
			})
		},
		createRow(){
			this.createForm = {
				contract_id: "",
				facility_type_id: 1,
				condition_id: 1,
				traffic_sign_id: ""
			}
			this.imageSelected = {
			    id: '',
			    src: '',
			    traffic_sign_type_id: ''
			 }
			this.traffic_sign_type_id = null
			$("#modalCreate").modal()
		},
		store(){
			console.log(this.facilities.length)
			this.isProcessing = true
			if(this.createForm.facility_type_id != this.facility_types[1].id){
				delete this.createForm.traffic_sign_id
			}
			this.createForm.contract_id = this.idContract
			axios.post('/facility', this.createForm).then((res) => {
				if(res.data.stored){
					$("#modalCreate").modal('hide')
					swal({
						title: "Sukses",
						text: res.data.msg,
						icon: "success",
						button: false,
						timer: 1200
					})
					var i
					i = this.contracts.findIndex(x => x.id == this.createForm.contract_id)
					this.createForm.contract = Object.assign({}, this.contracts[i])
					i = this.facility_types.findIndex(x => x.id == this.createForm.facility_type_id)
					this.createForm.type = Object.assign({}, this.facility_types[i])
					i = this.conditions.findIndex(x => x.id == this.createForm.condition_id)
					this.createForm.condition = Object.assign({}, this.conditions[i])
					this.createForm.traffic_sign = Object.assign({}, this.imageSelected)
					this.facilities.push(this.createForm)
					this.isProcessing = false
					this.createForm = {}
				} else {
					swal({
						title: "Info",
					  	text: res.data.msg,
					  	icon: "info",
					 	button: true
					})
					this.isProcessing = false
				}
			}).catch((err) => {
				this.error = err.response.data
				this.isProcessing = false
			})
		},
		destroy(data){
			swal({
			  title: "Anda yakin?",
			  text: "Data akan terhapus secara permanen!",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			})
			.then((willDelete) => {
			  if (willDelete) {
			    axios.delete('/facility/'+data.id).then((res) => {
					if(res.data.deleted){
						swal({
							title: "Sukses",
						  	text: res.data.msg,
						  	icon: "success",
						 	button: false,
						  	timer: 1200
						})
						const i = this.facilities.indexOf(data);
                        this.facilities.splice(i, 1);
					} else {
						swal({
							title: "Info",
						  	text: res.data.msg,
						  	icon: "info",
						 	button: true
						})
					}
				}).catch((err) => {
					console.log(err)
				})
			  } 
			})
		},
		selectContract(){
			const i = this.contracts.findIndex(x => x.id == this.idContract)
			this.selectedContract = Object.assign({}, this.contracts[i])
		},
		onSelectImage(data) {
	      this.imageSelected = Object.assign({}, this.imageSelected, data)
	      this.createForm.traffic_sign_id = this.imageSelected.id
	    },
	},
	watch: {
		traffic_sign_type_id(data){
			this.selectedTraffic = this.traffic_signs.filter(x => x.traffic_sign_type_id == data)
		}
	}
}

</script>