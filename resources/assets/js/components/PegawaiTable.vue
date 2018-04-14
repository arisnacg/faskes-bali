<template>
  <div>
    <table id="tbPegawai" class="table table-stripped table-responsive" width="100%" cellspacing="0">
      <thead>
		<tr>
			<th>No</th>
			<th>NIP</th>
			<th>Nama</th>
			<th>Jabatan</th>
			<th>Operasi</th>
		</tr>
      </thead>
      <tbody>
        <tr v-for="(employee, i) in employees">
            <td>{{ i + 1}}</td>
            <td>{{employee.nip}}</td>
            <td>{{employee.name}}</td>
            <td>{{employee.position.name}}</td>
            <td>
            	<button class="btn btn-success" @click="editRow(employee)">
            		<span class="fa fa-pencil"></span>
            	</button>
            	<button class="btn btn-danger" @click="destroy(employee)">
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

  	<!-- modal edit pegawai -->
	<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit Jadwal</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form @submit.prevent="update">
					<div class="modal-body">
						<div class="form-group">
							<label class="form-label">Nama Pegawai</label>
							<input type="text" class="form-control" v-model="editForm.name">
							<small class="error-control" v-if="error.name">{{error.name[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label" for="pegawai">NIP Pegawai</label>
							<input type="text" class="form-control" v-model="editForm.nip">
							<small class="error-control" v-if="error.nip">{{error.nip[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">Jabatan Pegawai</label>
							<select class="form-control" v-model="editForm.position_id">
								<option v-for="position in positions" :value="position.id">
									{{position.name}}
								</option>
							</select>
							<small class="error-control" v-if="error.position_id">{{error.position_id[0]}}</small>
						</div>
					</div>
					<div class="modal-footer">
						<button :disabled="isProcessing" type="submit" class="btn btn-success"><span class="fa fa-save"></span> Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- modal edit pegawai -->

	<!-- modal create pegawai -->
	<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit Jadwal</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form @submit.prevent="store">
					<div class="modal-body">
						<div class="form-group">
							<label class="form-label">Nama Pegawai</label>
							<input type="text" class="form-control" v-model="createForm.name">
							<small class="error-control" v-if="error.name">{{error.name[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label" for="pegawai">NIP Pegawai</label>
							<input type="text" class="form-control" v-model="createForm.nip">
							<small class="error-control" v-if="error.nip">{{error.nip[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">Jabatan Pegawai</label>
							<select class="form-control" v-model="createForm.position_id">
								<option v-for="position in positions" :value="position.id">
									{{position.name}}
								</option>
							</select>
							<small class="error-control" v-if="error.position_id">{{error.position_id[0]}}</small>
						</div>
					</div>
					<div class="modal-footer">
						<button :disabled="isProcessing" type="submit" class="btn btn-success"><span class="fa fa-save"></span> Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- modal create pegawai -->

  </div> 

</template>

<script>
  
export default {
	data(){
		return {
			isProcessing: false,
			employees: [],
			editForm: {},
			createForm: {
				position_id: 1
			},
			positions: [],
			error: {}
		}
	},
	created(){
		console.log($('meta[name="csrf-token"]').attr('content'))
		axios.get(`/employee`).then((res) => {
			this.employees = res.data.employees
			this.positions = res.data.positions
			$(document).ready(function(){
			    $('#tbPegawai').DataTable()
			})
		}).catch((err) => {
			console.log(err)
		})                                                            
	},
	methods: {
		editRow(data){
			this.editForm = Object.assign({}, data)
			$("#modalEdit").modal()
		},
		update(){
			this.isProcessing = true
			const i = this.positions.findIndex(x => x.id==this.editForm.position_id);
			this.editForm.position = this.positions[i]
			axios.put('/employee/'+this.editForm.id, this.editForm).then((res) => {
				if(res.data.updated){
					$("#modalEdit").modal('hide')
					swal({
						title: "Sukses",
						text: res.data.msg,
						icon: "success",
						button: false,
						timer: 1200
					})
					const i = this.employees.findIndex(x => x.id==this.editForm.id);
					this.employees[i] = Object.assign({}, this.editForm)
				}
				this.isProcessing = false
			}).catch((err) => {
				this.error = err.response.data;
				this.isProcessing = false
			})
		},
		createRow(){
			$("#modalCreate").modal()
		},
		store(){
			this.isProcessing = true
			axios.post('/employee', this.createForm).then((res) => {
				if(res.data.stored){
					$("#modalCreate").modal('hide')
					swal({
						title: "Sukses",
						text: res.data.msg,
						icon: "success",
						button: false,
						timer: 1200
					})
					const i = this.positions.findIndex(x => x.id==this.createForm.position_id)
					this.createForm.position = this.positions[i]
					this.employees.push(this.createForm)
					this.createForm = {}
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
			    axios.delete('/employee/'+data.id).then((res) => {
					if(res.data.deleted){
						swal({
							title: "Sukses",
						  	text: res.data.msg,
						  	icon: "success",
						 	button: false,
						  	timer: 1200
						})
						const i = this.employees.indexOf(data);
                        this.employees.splice(i, 1);
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