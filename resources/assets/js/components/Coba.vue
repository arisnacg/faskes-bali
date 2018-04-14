<template>
  <div>
		<vue-select-image :dataImages="dataImages"
	              		@onselectimage="onSelectImage">
	</vue-select-image>
  </div> 
</template>

<script>
import VueSelectImage from 'vue-select-image'
require('vue-select-image/dist/vue-select-image.css')

export default {
	components: {
		VueSelectImage
	},
	data(){
		return {
			imageSelected: {
			    id: '',
			    src: '',
			    alt: ''
			 },
			dataImages: [
				{
					id: 1,
					src: "images/rambu/larangan/1a.png",
					traffic_sign_type_id: 1
				},
				{
					id: 2,
					src: "images/rambu/larangan/1b.png",
					traffic_sign_type_id: 1
				}
			]
		}
	},
	methods: {
		onSelectImage: function (data) {
	      console.log('fire event onSelectImage: ', data)
	      this.imageSelected = Object.assign({}, this.imageSelected, data)
	    },
	},
	computed: {
		comImages(){
			return this.images
		}
	},
	created(){
		axios.get(`/facility`).then((res) => {
			this.images = res.data.traffic_signs
		}).catch((err) => {
			console.log(err)
		})
	}
}
</script>