<template>
  <div>
    <table id="table" class="table table-stripped table-responsive" width="100%" cellspacing="0">
      <thead>
		<tr>
			<th>No</th>
			<th>Kode</th>
			<th>Nilai</th>
			<th>Konsultan</th>
			<th>Kontraktor</th>
			<th>Tahun</th>
			<th>Operasi</th>
		</tr>
      </thead>
      <tbody>
        <tr v-for="(contract, i) in contracts">
        	<td>{{ i+1 }}</td>
            <td>{{ contract.code }}</td>
            <td>Rp. {{ contract.value }}</td>
            <td>Rp. {{ contract.consultant.name }}</td>
            <td>Rp. {{ contract.contractor.name }}</td>
            <td>{{ contract.year }}</td>
            <td>
            	<button class="btn btn-primary" @click="viewRow(contract)">
            		<span class="fa fa-eye"></span>
            	</button>
            	<button class="btn btn-success" @click="editRow(contract)">
            		<span class="fa fa-pencil"></span>
            	</button>
            	<button class="btn btn-danger" @click="destroy(contract)">
            		<span class="fa fa-trash"></span>
            	</button>
            </td>
        </tr>
      </tbody>
    </table>
  	<!-- tabel -->

	<!-- btn float -->
  	<div class="float-btn">
		<a @click.prevent="createRow"  class="btn-success"><span class="fa fa-plus"></span></a>
	</div>

	<!-- modal create -->
	<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Kontrak Baru</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form @submit.prevent="store">
					<div class="modal-body">
						<div class="form-group">
							<label class="form-label">Kode</label>
							<input type="text" class="form-control" v-model="createForm.code">
							<small class="error-control" v-if="error.code">{{error.code[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">Nilai</label>
							<div class="input-group">
								<div class="input-group-addon">Rp. </div>
								<input type="text" class="form-control" v-model="createForm.value">
							</div>
							<small class="error-control" v-if="error.value">{{error.value[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">Konsultan</label>
							<select class="form-control" v-model="createForm.consultant_id">
								<option value="empty" selected disabled>- Daftar Konsultan -</option>
								<option v-for="(partner, i) in partners" v-if="partner.type == 1" :value="partner.id">
									{{ partner.name }}
								</option>
							</select>
							<small class="error-control" v-if="error.consultant_id">{{error.consultant_id[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">Kontraktor</label>
							<select class="form-control" v-model="createForm.contractor_id">
								<option value="empty" selected disabled>- Daftar Kontraktor -</option>
								<option v-for="(partner, i) in partners" v-if="partner.type == 2" :value="partner.id">
									{{ partner.name }}
								</option>
							</select>
							<small class="error-control" v-if="error.contractor_id">{{error.contractor_id[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">PPK</label>
							<select class="form-control" v-model="createForm.ppk_id">
								<option value="empty" selected disabled>- Daftar Pegawai -</option>
								<option v-for="(employee, i) in employees" :value="employee.id">
									{{ employee.name }}
								</option>
							</select>
							<small class="error-control" v-if="error.ppk_id">{{error.ppk_id[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">PPTK</label>
							<select class="form-control" v-model="createForm.pptk_id">
								<option value="empty" selected disabled>- Daftar Pegawai -</option>
								<option v-for="(employee, i) in employees" :value="employee.id">
									{{ employee.name }}
								</option>
							</select>
							<small class="error-control" v-if="error.pptk_id">{{error.pptk_id[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">Tahun</label>
							<input type="text" class="form-control" v-model="createForm.year">
							<small class="error-control" v-if="error.year">{{error.year[0]}}</small>
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
	<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit Kontrak</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form @submit.prevent="update">
					<div class="modal-body">
						<div class="form-group">
							<label class="form-label">Kode</label>
							<input type="text" class="form-control" v-model="editForm.code">
							<small class="error-control" v-if="error.code">{{error.code[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">Nilai</label>
							<div class="input-group">
								<div class="input-group-addon">Rp. </div>
								<input type="text" class="form-control" v-model="editForm.value">
							</div>
							<small class="error-control" v-if="error.value">{{error.value[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">Konsultan</label>
							<select class="form-control" v-model="editForm.consultant_id">
								<option value="empty" selected disabled>- Daftar Konsultan -</option>
								<option v-for="(partner, i) in partners" v-if="partner.type == 1" :value="partner.id">
									{{ partner.name }}
								</option>
							</select>
							<small class="error-control" v-if="error.consultant_id">{{error.consultant_id[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">Kontraktor</label>
							<select class="form-control" v-model="editForm.contractor_id">
								<option value="empty" selected disabled>- Daftar Kontraktor -</option>
								<option v-for="(partner, i) in partners" v-if="partner.type == 2" :value="partner.id">
									{{ partner.name }}
								</option>
							</select>
							<small class="error-control" v-if="error.contractor_id">{{error.contractor_id[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">PPK</label>
							<select class="form-control" v-model="editForm.ppk_id">
								<option value="empty" selected disabled>- Daftar Pegawai -</option>
								<option v-for="(employee, i) in employees" :value="employee.id">
									{{ employee.name }}
								</option>
							</select>
							<small class="error-control" v-if="error.ppk_id">{{error.ppk_id[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">PPTK</label>
							<select class="form-control" v-model="editForm.pptk_id">
								<option value="empty" selected disabled>- Daftar Pegawai -</option>
								<option v-for="(employee, i) in employees" :value="employee.id">
									{{ employee.name }}
								</option>
							</select>
							<small class="error-control" v-if="error.pptk_id">{{error.pptk_id[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">Tahun</label>
							<input type="text" class="form-control" v-model="editForm.year">
							<small class="error-control" v-if="error.year">{{error.year[0]}}</small>
						</div>
						
					</div>
					<div class="modal-footer">
						<button :disabled="isProcessing" type="submit" class="btn btn-success"><span class="fa fa-save"></span> Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- modal view -->
	<div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Lihat Detail Kontrak</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form @submit.prevent="">
					<div class="modal-body">
						<div class="form-group">
							<label class="form-label">Kode</label>
							<input type="text" class="form-control" v-model="viewForm.code">
						</div>
						<div class="form-group">
							<label class="form-label">Nilai</label>
							<div class="input-group">
								<div class="input-group-addon">Rp. </div>
								<input type="text" class="form-control" v-model="viewForm.value">
							</div>
						</div>
						<div class="form-group">
							<label class="form-label">Konsultan</label>
							<select class="form-control" v-model="viewForm.consultant_id">
								<option value="empty" selected disabled>- Daftar Rekanan -</option>
								<option v-for="(partner, i) in partners" :value="partner.id">
									{{ partner.name }}
								</option>
							</select>
						</div>
						<div class="form-group">
							<label class="form-label">Kontraktor</label>
							<select class="form-control" v-model="viewForm.contractor_id">
								<option value="empty" selected disabled>- Daftar Rekanan -</option>
								<option v-for="(partner, i) in partners" :value="partner.id">
									{{ partner.name }}
								</option>
							</select>
						</div>
						<div class="form-group">
							<label class="form-label">PPK</label>
							<select class="form-control" v-model="viewForm.ppk_id">
								<option value="empty" selected disabled>- Daftar Pegawai -</option>
								<option v-for="(employee, i) in employees" :value="employee.id">
									{{ employee.name }}
								</option>
							</select>
						</div>
						<div class="form-group">
							<label class="form-label">PPTK</label>
							<select class="form-control" v-model="viewForm.pptk_id">
								<option value="empty" selected disabled>- Daftar Pegawai -</option>
								<option v-for="(employee, i) in employees" :value="employee.id">
									{{ employee.name }}
								</option>
							</select>
						</div>
						<div class="form-group">
							<label class="form-label">Tahun</label>
							<input type="text" class="form-control" v-model="viewForm.year">
						</div>
						
					</div>
				</form>
			</div>
		</div>
	</div>

  </div> 

</template>

<script>
  
export default {
	data(){
		return {
			isProcessing: false,
			contracts: [],
			partners: [],
			employees: [],
			editForm: {},
			createForm: {
				value: 0,
				consultant_id: "empty",
		    	contractor_id: "empty",
		    	ppk_id: "empty",
		    	pptk_id: "empty",
		    	year: 0
			},
			viewForm: {},
			types: ["Kontraktor", "Konsultan"],
			error: {}
		}
	},
	created(){
		axios.get(`/contract`).then((res) => {
			this.contracts = res.data.contracts
			$(document).ready(function(){
			    $('#table').DataTable()
			})
		}).catch((err) => {
			console.log(err)
		}) 

		axios.get(`/employee`).then((res) => {
			this.employees = res.data.employees
		}).catch((err) => {
			console.log(err)
		}) 

		axios.get(`/partner`).then((res) => {
			this.partners = res.data.partners
		}).catch((err) => {
			console.log(err)
		})
		const date = new Date()
		this.createForm.year = date.getFullYear()                                                    
	},
	methods: {
		viewRow(data){
			this.viewForm = data
			$("#modalView").modal()
		},
		editRow(data){
			this.editForm = Object.assign({}, data)
			$("#modalEdit").modal()
		},
		update(){
			this.isProcessing = true
			axios.put('/contract/'+this.editForm.id, this.editForm).then((res) => {
				if(res.data.updated){
					$("#modalEdit").modal('hide')
					swal({
						title: "Sukses",
						text: res.data.msg,
						icon: "success",
						button: false,
						timer: 1200
					})
					var i
					i = this.employees.findIndex(x => x.id==this.editForm.consultant_id)
					this.editForm.consultant = Object.assign({}, this.employees[i])
					i = this.employees.findIndex(x => x.id==this.editForm.contractor_id)
					this.editForm.contractor = Object.assign({}, this.employees[i])
					i = this.partners.findIndex(x => x.id==this.editForm.ppk_id)
					this.editForm.ppk = Object.assign({}, this.partners[i])
					i = this.partners.findIndex(x => x.id==this.editForm.pptk_id)
					this.editForm.pptk = Object.assign({}, this.partners[i])
					i = this.contracts.findIndex(x => x.id == this.editForm.id)
					this.contracts[i] = Object.assign({}, this.editForm)
					this.error = {}
					this.isProcessing = false
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
		createRow(){
			$("#modalCreate").modal()
		},
		store(){
			this.isProcessing = true
			axios.post('/contract', this.createForm).then((res) => {
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
					i = this.employees.findIndex(x => x.id==this.createForm.consultant_id)
					this.createForm.consultant = Object.assign({}, this.employees[i])
					i = this.employees.findIndex(x => x.id==this.createForm.contractor_id)
					this.createForm.contractor = Object.assign({}, this.employees[i])
					i = this.partners.findIndex(x => x.id==this.createForm.ppk_id)
					this.createForm.ppk = Object.assign({}, this.partners[i])
					i = this.partners.findIndex(x => x.id==this.createForm.pptk_id)
					this.createForm.pptk = Object.assign({}, this.partners[i])
					this.contracts.push(this.createForm)
					this.createForm = {}
					this.error = {}
					this.isProcessing = false
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
			  text: "Kontrak dan semua fasilitas dalam kontrak akan terhapus permanen!",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			})
			.then((willDelete) => {
			  if (willDelete) {
			    axios.delete('/contract/'+data.id).then((res) => {
					if(res.data.deleted){
						swal({
							title: "Sukses",
						  	text: res.data.msg,
						  	icon: "success",
						 	button: false,
						  	timer: 1200
						})
						const i = this.contracts.indexOf(data);
                        this.contracts.splice(i, 1);
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
		}
	}
}

</script>