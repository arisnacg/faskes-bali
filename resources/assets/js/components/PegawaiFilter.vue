<template>
  <div>
  	<div class="gray-border">
  		<form @submit.prevent="search">
  			<div class="form-group col-sm-12 col-md-4">
  				<label class="label-control">Jabatan</label>
  				<!-- <select id="basic" class="selectpicker show-tick form-control" data-live-search="true">
					<option value="" selected disabled>- Daftar Jabatan -</option>
  					<option v-for="position in positions" :value="position.id">
  						{{ position.name }}
  					</option>
				</select> -->
  				<select class="selectpicker form-control" data-live-search="true" v-model="filter.position_id">
  					<option value="" selected disabled>- Daftar Jabatan -</option>
  					<option v-for="position in positions" :value="position.id">
  						{{ position.name }}
  					</option>
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
			<th>NIP</th>
			<th>Nama</th>
			<th>Jabatan</th>
		</tr>
      </thead>
      <tbody>
        <tr v-for="(row, i) in rows">
            <td>{{ i + 1}}</td>
            <td>{{row.nip}}</td>
            <td>{{row.name}}</td>
            <td>{{row.position.name}}</td>
        </tr>
      </tbody>
    </table>
  	<!-- tabel -->

  </div> 

</template>

<script>
  
export default {
	data(){
		return {
			rows: [],
			filter: {
				position_id: ""
			},
			positions: [],
			isProcessing: false
		}
	},
	created(){
		axios.get(`/employee`).then((res) => {
			this.rows = res.data.employees
			this.positions = res.data.positions
			$(document).ready(function(){
			    $('#table').DataTable()
			})
		}).catch((err) => {
			console.log(err)
		})                                                            
	},
	methods: {
		search(){
			this.isProcessing = true
			axios.post(`/filter/employee`, this.filter).then((res) => {
				this.rows = res.data.employees
				this.isProcessing = false
			}).catch((err) => {
				console.log(err)
			})  
		},
		print(){
			this.isProcessing = true
			axios.post(`/pdf/pegawai`, this.filter).then((res) => {
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