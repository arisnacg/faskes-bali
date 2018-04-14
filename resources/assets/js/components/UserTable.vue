<template>
  <div>
    <table id="table" class="table table-stripped table-responsive" width="100%" cellspacing="0">
      <thead>
		<tr>
			<th>No</th>
			<th>Email</th>
			<th>Pegawai</th>
			<th>Operasi</th>
		</tr>
      </thead>
      <tbody>
        <tr v-for="(user, i) in users">
            <td>{{ i + 1}}</td>
            <td>{{user.email}}</td>
            <td>{{user.employee.name}}</td>
            <td>
            	<!-- <button class="btn btn-success" @click="editRow(user)">
            		<span class="fa fa-pencil"></span>
            	</button> -->
            	<button class="btn btn-danger" @click="destroy(user)">
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

  	<!-- modal edit -->
  	<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit User</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form @submit.prevent="update">
					<div class="modal-body">
						<div class="form-group">
							<label class="form-label">Email</label>
							<input type="email" class="form-control" v-model="editForm.email">
							<small class="error-control" v-if="error.email">{{error.email[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label" for="pegawai">Password</label>
							<input type="password" class="form-control" v-model="editForm.password">
							<small class="error-control" v-if="error.password">{{error.password[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label" for="pegawai">Konfirmasi Password</label>
							<input type="password" class="form-control" v-model="editForm.password_confirmation">
						</div>
						<div class="form-group">
							<label class="form-label">Dari Pegawai</label>
							<select class="form-control" v-model="editForm.employee_id">
								<option v-for="employee in validEmployees" :value="employee.id">
									{{employee.name}}
								</option>
							</select>
							<small class="error-control" v-if="error.employee_id">{{error.employee_id[0]}}</small>
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
					<h5 class="modal-title">User Baru</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form @submit.prevent="store">
					<div class="modal-body">
						<div class="form-group">
							<label class="form-label">Email</label>
							<input type="email" class="form-control" v-model="createForm.email">
							<small class="error-control" v-if="error.email">{{error.email[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label" for="pegawai">Password</label>
							<input type="password" class="form-control" v-model="createForm.password">
							<small class="error-control" v-if="error.password">{{error.password[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label" for="pegawai">Konfirmasi Password</label>
							<input type="password" class="form-control" v-model="createForm.password_confirmation">
						</div>
						<div class="form-group">
							<label class="form-label">Dari Pegawai</label>
							<select class="form-control" v-model="createForm.employee_id">
								<option v-for="employee in validEmployees" :value="employee.id">
									{{employee.name}}
								</option>
							</select>
							<small class="error-control" v-if="error.employee_id">{{error.employee_id[0]}}</small>
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
  
export default {
	data(){
		return {
			isProcessing: false,
			users: [],
			editForm: {},
			createForm: {
				employee_id: 1,
				employee: {}
			},
			validEmployees: [],
			error: {}
		}
	},
	created(){
		axios.get(`/user`).then((res) => {
			this.users = res.data.users
			this.validEmployees = res.data.validEmployees
			$(document).ready(function(){
			    $('#table').DataTable()
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
			const i = this.validEmployees.findIndex(x => x.id==this.editForm.employee_id);
			this.editForm.employee = Object.assign({}, this.validEmployees[i])
			axios.put('/user/'+this.editForm.id, this.editForm).then((res) => {
				if(res.data.updated){
					$("#modalEdit").modal('hide')
					swal({
						title: "Sukses",
						text: res.data.msg,
						icon: "success",
						button: false,
						timer: 1200
					})
					const i = this.users.findIndex(x => x.id==this.editForm.id);
					this.users[i] = Object.assign({}, this.editForm)
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
			axios.post('/user', this.createForm).then((res) => {
				if(res.data.stored){
					$("#modalCreate").modal('hide')
					swal({
						title: "Sukses",
						text: res.data.msg,
						icon: "success",
						button: false,
						timer: 1200
					})
					const i = this.validEmployees.findIndex(x => x.id==this.createForm.employee_id);
					this.createForm.employee = Object.assign({}, this.validEmployees[i])
					this.users.push(this.createForm)
					this.createForm = {}
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
			  text: "Data akan terhapus secara permanen!",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			})
			.then((willDelete) => {
			  if (willDelete) {
			    axios.delete('/user/'+data.id).then((res) => {
					if(res.data.deleted){
						swal({
							title: "Sukses",
						  	text: res.data.msg,
						  	icon: "success",
						 	button: false,
						  	timer: 1200
						})
						const i = this.users.indexOf(data);
                        this.users.splice(i, 1);
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