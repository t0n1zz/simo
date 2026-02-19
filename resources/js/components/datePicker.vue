<template>
    <VueDatePicker 
        class="w-100" 
        v-model="time" 
        format="dd-MM-yyyy" 
        model-type="dd-MM-yyyy"
        placeholder="Pilih Tanggal" 
        :text-input="true"
        @update:model-value="onChanged"
        auto-apply
        :enable-time-picker="false"
    ></VueDatePicker>
</template>

<script>
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import moment from 'moment';

export default {
    props:['defaultDate'],
    components:{
        VueDatePicker
    },
    data() {
        return {
            time: '',
            dateVal:''
        }
    },
    mounted(){
        if(this.defaultDate =='' || this.defaultDate == null){
            this.time = moment().format("DD-MM-YYYY");
            this.dateVal = moment().format("YYYY-MM-DD");
            this.$emit('dateSelected', this.dateVal );
        }else{
            this.time = moment(this.defaultDate, "YYYY-MM-DD").format("DD-MM-YYYY");
            this.$emit('dateSelected', this.defaultDate );
        }
    },
    watch: {
        defaultDate: function(newVal, oldVal) {
            if(newVal){
                this.time = moment(newVal, "YYYY-MM-DD").format("DD-MM-YYYY");
            }
        }
    },
    methods: {
        onChanged (val) {
            if(val){
                this.dateVal = moment(val, "DD-MM-YYYY").format("YYYY-MM-DD");
                this.$emit('dateSelected', this.dateVal );
            } else {
                this.$emit('dateSelected', null);
            }
        },
    },
}
</script>

<style>
.dp__menu {
    z-index: 99999 !important;
}
</style>