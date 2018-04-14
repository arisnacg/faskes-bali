<template>
  <div>
  	<div class="gray-border">
  		<form @submit.prevent="search">

  			<div class="row">
  				<div class="col-sm-12 col-md-4">
	  				<div class="form-group">
		  				<label class="label-control">Kode Kontrak</label>
		  				<select class="form-control" v-model="filter.contract_id">
		  					<option value="" selected>- Semua Kontrak -</option>
		  					<option v-for="contract in contracts" :value="contract.id">
		  						{{ contract.code }}
		  					</option>
		  				</select>
		  			</div>
		  			<div class="form-group">
		  				<label class="label-control">Kondisi</label>
		  				<select class="form-control" v-model="filter.condition_id">
		  					<option value="" selected>- Semua Kondisi -</option>
		  					<option v-for="condition in conditions"	:value="condition.id">
		  						{{ condition.name }}
		  					</option>
		  				</select>
		  			</div>
		  		</div>
		  		<div class="col-sm-12 col-md-4">
		  			<div class="form-group">
		  				<label class="label-control">Jenis</label>
		  				<select class="form-control" v-model="filter.facility_type_id">
		  					<option value="" selected>- Semua Jenis Facilitas -</option>
		  					<option v-for="facility_type in facility_types"	:value="facility_type.id">
		  						{{ facility_type.name }}
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
			<th>Kode Kontrak</th>
			<th>Jenis</th>
			<th>Kondisi</th>
			<th>Detail</th>
		</tr>
      </thead>
      <tbody>
        <tr v-for="(row, i) in rows">
            <td>{{ i + 1 }}</td>
			<td>{{ row.code }}</td>
			<td>{{ row.contract.code }}</td>
			<td>{{ row.type.name }}</td>
			<td>{{ row.condition.name }}</td>
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
						<div class="form-group" v-show="viewForm.facility_type_id===2">
							<label class="form-label">Jenis Rambu</label>
							<select class="form-control" disabled>
								<option value="empty" selected disabled>{{viewForm.traffic_sign[0].name}}</option>
							</select>
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

  </div> 

</template>

<script>
  
export default {
	data(){
		return {
			rows: [],
			filter: {
				condition_id: '',
				facility_type_id: '',
				contract_id: '',
			},
			facility_types: [],
			contracts: [],
			conditions: [],
			viewForm: {
				traffic_sign: [
					{name: ''}
				]
			},
			isProcessing: false
		}
	},
	created(){
		axios.get(`/facility`).then((res) => {
			this.rows = res.data.facilities
			this.facility_types = res.data.facility_types
			this.conditions = res.data.conditions
			$(document).ready(function(){
			    $('#table').DataTable()
			})
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
			this.viewForm = data
			$("#modalView").modal()
		},
		search(){
			this.isProcessing = true
			axios.post(`/filter/facility`, this.filter).then((res) => {
				this.rows = res.data.facilities
				this.isProcessing = false
			}).catch((err) => {
				console.log(err)
			})  
		},
		print(){
			this.isProcessing = true
			axios.post(`/pdf/fasilitas`, this.filter).then((res) => {
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