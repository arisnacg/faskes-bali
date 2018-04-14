<template>
  <div>
  	<div class="gray-border">
  		<form @submit.prevent="search">

  			<div class="row">
  				<div class="col-sm-12 col-md-4">
	  				<div class="form-group">
		  				<label class="label-control">Konsultan</label>
		  				<select class="form-control" v-model="filter.consultant_id">
		  					<option value="" selected>- Semua Konsultan -</option>
		  					<option v-for="partner in partners"
		  							v-if="partner.type == 1"
		  							:value="partner.id">
		  						{{ partner.name }}
		  					</option>
		  				</select>
		  			</div>
		  			<div class="form-group">
		  				<label class="label-control">Kontrakor</label>
		  				<select class="form-control" v-model="filter.contractor_id">
		  					<option value="" selected>- Semua Kontraktor -</option>
		  					<option v-for="partner in partners"
		  							v-if="partner.type == 2"
		  							:value="partner.id">
		  						{{ partner.name }}
		  					</option>
		  				</select>
		  			</div>
		  		</div>
		  		<div class="col-sm-12 col-md-4">
	  				<div class="form-group">
		  				<label class="label-control">PPK</label>
		  				<select class="form-control" v-model="filter.ppk_id">
		  					<option value="" selected>- Semua Pegawai -</option>
		  					<option v-for="employee in employees"
		  							:value="employee.id">
		  						{{ employee.name }}
		  					</option>
		  				</select>
		  			</div>
		  			<div class="form-group">
		  				<label class="label-control">PPTK</label>
		  				<select class="form-control" v-model="filter.pptk_id">
		  					<option value="" selected>- Semua Pegawai -</option>
		  					<option v-for="employee in employees"
		  							:value="employee.id">
		  						{{ employee.name }}
		  					</option>
		  				</select>
		  			</div>
		  		</div>
  			</div>
  			<div class="form-group">
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
			<th>Kode</th>
			<th>Nilai</th>
			<th>Konsultan</th>
			<th>Kontraktor</th>
			<th>Detail</th>
		</tr>
      </thead>
      <tbody>
        <tr v-for="(row, i) in rows">
            <td>{{ i + 1}}</td>
            <td>{{row.code}}</td>
            <td>Rp. {{row.value}}</td>
            <td>{{row.consultant.name}}</td>
            <td>{{row.contractor.name}}</td>
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
					<h5 class="modal-title">Lihat Detail Kontrak</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form @submit.prevent="">
					<div class="modal-body">
						<div class="form-group">
							<label class="form-label">Kode</label>
							<input type="text" class="form-control" v-model="viewForm.code" disabled>
						</div>
						<div class="form-group">
							<label class="form-label">Nilai</label>
							<div class="input-group">
								<div class="input-group-addon">Rp. </div>
								<input type="text" class="form-control" v-model="viewForm.value" disabled>
							</div>
						</div>
						<div class="form-group">
							<label class="form-label">Konsultan</label>
							<select class="form-control" v-model="viewForm.consultant_id" disabled>
								<option value="empty" selected disabled>- Daftar Rekanan -</option>
								<option v-for="(partner, i) in partners" :value="partner.id">
									{{ partner.name }}
								</option>
							</select>
						</div>
						<div class="form-group">
							<label class="form-label">Kontraktor</label>
							<select class="form-control" v-model="viewForm.contractor_id" disabled>
								<option value="empty" selected disabled>- Daftar Rekanan -</option>
								<option v-for="(partner, i) in partners" :value="partner.id">
									{{ partner.name }}
								</option>
							</select>
						</div>
						<div class="form-group">
							<label class="form-label">PPK</label>
							<select class="form-control" v-model="viewForm.ppk_id" disabled>
								<option value="empty" selected disabled>- Daftar Pegawai -</option>
								<option v-for="(employee, i) in employees" :value="employee.id">
									{{ employee.name }}
								</option>
							</select>
						</div>
						<div class="form-group">
							<label class="form-label">PPTK</label>
							<select class="form-control" v-model="viewForm.pptk_id" disabled>
								<option value="empty" selected disabled>- Daftar Pegawai -</option>
								<option v-for="(employee, i) in employees" :value="employee.id">
									{{ employee.name }}
								</option>
							</select>
						</div>
						<div class="form-group">
							<label class="form-label">Tahun</label>
							<input type="text" class="form-control" v-model="viewForm.year" disabled>
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
				consultant_id: "",
				contractor_id: "",
				ppk_id: "",
				pptk_id: ""
			},
			employees: [],
			partners: [],
			viewForm: {},
			isProcessing: false
		}
	},
	created(){
		axios.get(`/contract`).then((res) => {
			this.rows = res.data.contracts
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
	},
	methods: {
		viewRow(data){
			this.viewForm = data
			$("#modalView").modal()
		},
		search(){
			this.isProcessing = true
			axios.post(`/filter/contract`, this.filter).then((res) => {
				this.rows = res.data.contracts
				this.isProcessing = false
			}).catch((err) => {
				console.log(err)
			})  
		},
		print(){
			this.isProcessing = true
			axios.post(`/pdf/kontrak`, this.filter).then((res) => {
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