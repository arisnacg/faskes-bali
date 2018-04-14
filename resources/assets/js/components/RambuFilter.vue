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
		  			<div class="form-group">
		  				<label class="label-control">Tabel Rambu</label>
		  				<select class="form-control" v-model="traffic_sign_type_id">
		  					<option value="" selected>- Tabel Rambu -</option>
		  					<option v-for="data in traffic_sign_types"	:value="data.id">
		  						{{ data.name }}
		  					</option>
		  				</select>
		  			</div>
		  		</div>
  			</div>
  			<div class="row">
  				<div class="col-sm-12">
  					<div class="form-group" v-if="traffic_sign_type_id">
		  				<label class="label-control">Jenis Rambu</label>
		  				<ImageSelect :dataImages="selectedTraffic"
								      @onselectimage="onSelectImage">
						</ImageSelect>
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
			<th>Kode Rambu</th>
			<th>Kode Kontrak</th>
			<th>Tabel Rambu</th>
			<th>Jenis Rambu</th>
			<th>Kondisi</th>
			<th>Detail</th>
		</tr>
      </thead>
      <tbody>
        <tr v-for="(row, i) in rows" v-if="row.facility_type_id == 2">
            <td>{{ i + 1 }}</td>
			<td>{{ row.code }}</td>
			<td>{{ row.contract_code }}</td>
			<td>{{ row.traffic_sign_type_name }}</td>
			<td>
				<img v-bind:src="row.src">
			</td>
			<td>{{ row.condition_name }}</td>
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
							<label class="form-label">Tabel Rambu</label>
							<input type="text" class="form-control" v-model="viewForm.traffic_sign_type_name" disabled>
						</div>
						<div class="form-group">
							<label class="form-label" style="display: block">Jenis Rambu</label>
							<img :src="viewForm.src" width="80px" height="80px">
						</div>
						<div class="form-group">
							<label class="form-label">Volume</label>
							<input type="text" class="form-control" v-model="viewForm.volume" disabled>
						</div>
						<div class="form-group">
							<label class="form-label">Kondisi Fasilitas</label>
							<input type="text" class="form-control" v-model="viewForm.condition_name" disabled>
						</div>
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
			rows: [],
			filter: {
				condition_id: '',
				contract_id: '',
				traffic_sign_type_id: '',
				traffic_sign_id: ''
			},
			traffic_sign_types: [],
			contracts: [],
			conditions: [],
			viewForm: {
				traffic_sign: [
					{name: ''}
				]
			},
			isProcessing: false,
			imageSelected: {
			    id: '',
			    src: '',
			    traffic_sign_type_id: ''
			 },
			 traffic_sign_type_id: '',
			 selectedTraffic: []
		}
	},
	created(){
		axios.post(`/filter/traffic_sign`).then((res) => {
			this.rows = res.data.facilities
			this.selectedTraffic = res.data.traffic_signs
			this.traffic_sign_types = res.data.traffic_sign_types
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
			this.filter.traffic_sign_type_id = this.traffic_sign_type_id
			if(this.traffic_sign_type_id == '')
				delete this.filter.traffic_sign_id
			axios.post(`/filter/traffic_sign`, this.filter).then((res) => {
				this.rows = res.data.facilities
				this.isProcessing = false
			}).catch((err) => {
				console.log(err)
			})  
		},
		print(){
			this.isProcessing = true
			this.filter.traffic_sign_type_id = this.traffic_sign_type_id
			if(this.traffic_sign_type_id == '')
				delete this.filter.traffic_sign_id
			axios.post(`/pdf/rambu`, this.filter).then((res) => {
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
		},
		onSelectImage(data) {
	      this.imageSelected = Object.assign({}, this.imageSelected, data)
	      this.filter.traffic_sign_id = this.imageSelected.id
	    },
	    getTabelRambu(data){
	    	const i = this.traffic_sign_types.findIndex(x => x.id == data.traffic_sign[0].traffic_sign_type_id)
	    	return this.traffic_sign_types[i]
	    }
	},
	watch: {
		traffic_sign_type_id(data){
			this.selectedTraffic = this.traffic_signs.filter(x => x.traffic_sign_type_id == data)
		}
	}
}

</script>

<style scoped>
	
td img {
	width: 35px;
	height: 35px;
	display: block;
	margin: 0 auto;
}

</style>