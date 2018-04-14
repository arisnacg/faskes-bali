<template>
  <div>
  	<div class="gray-border">
  		<form @submit.prevent="search">
  			<div class="form-group col-sm-12 col-md-4">
  				<label class="label-control">Jenis Rekanan</label>
  				<select class="form-control" v-model="filter.type">
  					<option value="" selected disabled>- Daftar Tipe Rekanan -</option>
  					<option v-for="(name, i) in types" :value="i+1">{{ name }}</option>
  				</select>
  			</div>
  			<div class="form-group col-sm-12 col-md-4">
				<button type="submit" class="btn btn-primary" :disabled="isProcessing">
					<span class="fa fa-filter"></span> Filter
				</button>
				<button @click="print" class="btn btn-success" :disabled="isProcessing">
					<span class="fa fa-print"></span>  Print to PDF
				</button>
  			</div>
  		</form>
  	</div>
  	<br>
    <table id="table" class="table table-stripped table-responsive" width="100%" cellspacing="0">
      <thead>
		<tr>
			<th>No</th>
			<th>Nama</th>
			<th>Direktur</th>
			<th>Telepon</th>
			<th>Jenis</th>
			<th>Detail</th>
		</tr>
      </thead>
      <tbody>
        <tr v-for="(row, i) in rows">
            <td>{{ i + 1}}</td>
            <td>{{row.name}}</td>
            <td>{{row.director}}</td>
            <td>{{row.phone}}</td>
            <td>{{types[row.type-1]}}</td>
            <td>
            	<button class="btn btn-primary" @click="viewRow(row)">
            		<span class="fa fa-eye"></span>
            	</button>
            </td>
        </tr>
      </tbody>
    </table>
  	<!-- tabel -->

	<!-- modal view -->
	<div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Lihat Detail Rekanan</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form>
					<div class="modal-body">
						<div class="form-group">
							<label class="form-label">Nama</label>
							<input type="text" class="form-control" v-model="viewForm.name" disabled>
						</div>
						<div class="form-group">
							<label class="form-label">Direktur</label>
							<input type="text" class="form-control" v-model="viewForm.director" disabled>
						</div>
						<div class="form-group">
							<label class="form-label">Alamat</label>
							<textarea class="form-control" v-model="viewForm.address" rows="2" disabled></textarea>
						</div>
						<div class="form-group">
							<label class="form-label">Email</label>
							<input type="email" class="form-control" v-model="viewForm.email" disabled>
						</div>
						<div class="form-group">
							<label class="form-label">Telepon</label>
							<input type="text" class="form-control" v-model="viewForm.phone" disabled>
						</div>
						<div class="form-group">
							<label class="form-label">Jenis Rekanan</label>
							<select class="form-control" v-model="viewForm.type" disabled>
								<option v-for="(type, i) in types" :value="i+1">
									{{type}}
								</option>
							</select>
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
			rows: [],
			filter: {
				type: ""
			},
			types: ["Konsultan", "Kontraktor"],
			viewForm: {},
			isProcessing: false
		}
	},
	created(){
		axios.get(`/partner`).then((res) => {
			this.rows = res.data.partners
			this.positions = res.data.positions
			$(document).ready(function(){
			    $('#table').DataTable()
			})
		}).catch((err) => {
			console.log(err)
		})                                                            
	},
	methods: {
		viewRow(data){
			this.viewForm = data
			$("#modalView").modal()
		},
		search(){
			this.isProcessing = true
			axios.post(`/filter/partner`, this.filter).then((res) => {
				this.rows = res.data.partners
				this.isProcessing = false
			}).catch((err) => {
				console.log(err)
			})  
		},
		print(){
			this.isProcessing = true
			axios.post(`/pdf/rekanan`, this.filter).then((res) => {
				var file = res.data.filename
				if(res.data.printed)
					axios.get('/pdf/download/'+res.data.filename, {responseType: 'arraybuffer'}).then((res) => {
						const url = window.URL.createObjectURL(new Blob([res.data], { type: 'application/pdf'}))
						const link = document.createElement('a')
						link.href = url
						link.download = file
						link.click()
						this.isProcessing = false
					})
			}).catch((err) => {
				console.log(err)
			})
		}
	}
}

</script>