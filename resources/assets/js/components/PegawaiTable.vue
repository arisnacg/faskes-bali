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
        <tr v-for="(row, i) in rows">
            <td>{{ i + 1}}</td>
            <td>{{row.nip}}</td>
            <td>{{row.name}}</td>
            <td>{{row.jabatan}}</td>
            <td>
            	<button class="btn btn-success" onclick="">Modal</button>
            </td>
        </tr>
      </tbody>
    </table>
  	<!-- tabel -->
  	<!-- modal edit jadwal -->
	<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit Jadwal</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form>
					<div class="modal-body">
						<div class="form-group">
							<input type="text" placeholder="Nama Pegawai">
						</div>
						<div class="form-group">
							<input type="text" placeholder="NIP Pegawai">
						</div>
						<div class="form-group">
							<label class="form-label" for="pegawai">Jabatan Pegawai</label>
							<select class="form-control" name="pegawai" id="sl-nama-pegawai">
								<option value="1">Gus Arisna</option>
								<option value="2">Iduar Perdana</option>
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- modal edit jadwal -->
  </div> 

</template>

<script>
  
export default {
	data(){
		return {
			rows: [
				{name : "Row 1", nip: 101, jabatan: "Kasir"},
				{name : "Row 2", nip: 101, jabatan: "Kasir"},
				{name : "Row 3", nip: 101, jabatan: "Kasir"},
				{name : "Row 4", nip: 101, jabatan: "Kasir"},
			]
		}
	},
	created(){
		$(document).ready(function(){
		    $('#tbPegawai').DataTable()
		})                                                                      
	}
}

</script>