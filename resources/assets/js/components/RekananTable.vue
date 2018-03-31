<template>
  <div>
    <table id="table" class="table table-stripped table-responsive" width="100%" cellspacing="0">
      <thead>
		<tr>
			<th>No</th>
			<th>Nama</th>
			<th>Direktor</th>
			<th>Alamat</th>
			<th>Email</th>
			<th>Telepon</th>
			<th>Tipe</th>
			<th>Operasi</th>
		</tr>
      </thead>
      <tbody>
        <tr v-for="(partner, i) in partners">
            <td>{{ i + 1}}</td>
            <td>{{partner.name}}</td>
            <td>{{partner.director}}</td>
            <td>{{partner.address}}</td>
            <td>{{partner.email}}</td>
            <td>{{partner.phone}}</td>
            <td>{{types[partner.type-1]}}</td>
            <td>
            	<button class="btn btn-success" @click="editRow(partner)">
            		<span class="fa fa-pencil"></span>
            	</button>
            	<button class="btn btn-danger" @click="destroy(partner)">
            		<span class="fa fa-trash"></span>
            	</button>
            </td>
        </tr>
      </tbody>
    </table>
  	<!-- tabel -->

	<!-- btn float -->
  	<div class="float-btn">
		<a @click.prevent="createRow"  class="btn-success" data-toggle="tooltip" data-placement="top" title="Tambah Jadwal"><span class="fa fa-plus"></span></a>
	</div>

  	<!-- modal edit -->
  	<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit Rekanan</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form @submit.prevent="update">
					<div class="modal-body">
						<div class="form-group">
							<label class="form-label">Nama</label>
							<input type="text" class="form-control" v-model="editForm.name">
							<small class="error-control" v-if="error.name">{{error.name[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">Direktur</label>
							<input type="text" class="form-control" v-model="editForm.director">
							<small class="error-control" v-if="error.director">{{error.director[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">Alamat</label>
							<textarea class="form-control" v-model="editForm.address" rows="2"></textarea>
							<small class="error-control" v-if="error.address">{{error.address[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">Email</label>
							<input type="email" class="form-control" v-model="editForm.email">
							<small class="error-control" v-if="error.email">{{error.email[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">Telepon</label>
							<input type="text" class="form-control" v-model="editForm.phone">
							<small class="error-control" v-if="error.phone">{{error.phone[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">Jenis Rekanan</label>
							<select class="form-control" v-model="editForm.type">
								<option v-for="(type, i) in types" :value="i+1">
									{{type}}
								</option>
							</select>
							<small class="error-control" v-if="error.type">{{error.type[0]}}</small>
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
					<h5 class="modal-title">Rekanan Baru</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form @submit.prevent="store">
					<div class="modal-body">
						<div class="form-group">
							<label class="form-label">Nama</label>
							<input type="text" class="form-control" v-model="createForm.name">
							<small class="error-control" v-if="error.name">{{error.name[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">Direktur</label>
							<input type="text" class="form-control" v-model="createForm.director">
							<small class="error-control" v-if="error.director">{{error.director[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">Alamat</label>
							<textarea class="form-control" v-model="createForm.address" rows="2"></textarea>
							<small class="error-control" v-if="error.address">{{error.address[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">Email</label>
							<input type="email" class="form-control" v-model="createForm.email">
							<small class="error-control" v-if="error.email">{{error.email[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">Telepon</label>
							<input type="text" class="form-control" v-model="createForm.phone">
							<small class="error-control" v-if="error.phone">{{error.phone[0]}}</small>
						</div>
						<div class="form-group">
							<label class="form-label">Jenis Rekanan</label>
							<select class="form-control" v-model="createForm.type">
								<option v-for="(type, i) in types" :value="i+1">
									{{type}}
								</option>
							</select>
							<small class="error-control" v-if="error.type">{{error.type[0]}}</small>
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
			partners: [],
			editForm: {},
			createForm: {
				type: 1
			},
			types: ["Kontraktor", "Konsultan"],
			error: {}
		}
	},
	created(){
		axios.get(`/partner`).then((res) => {
			this.partners = res.data.partners
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
			$("#modalCreate").modal()
		},
		store(){
			this.isProcessing = true
			axios.post('/partner', this.createForm).then((res) => {
				if(res.data.stored){
					$("#modalCreate").modal('hide')
					swal({
						title: "Sukses",
						text: res.data.msg,
						icon: "success",
						button: false,
						timer: 1200
					})
					this.partners.push(this.createForm)
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
			    axios.delete('/partner/'+data.id).then((res) => {
					if(res.data.deleted){
						swal({
							title: "Sukses",
						  	text: res.data.msg,
						  	icon: "success",
						 	button: false,
						  	timer: 1200
						})
						const i = this.partners.indexOf(data);
                        this.partners.splice(i, 1);
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