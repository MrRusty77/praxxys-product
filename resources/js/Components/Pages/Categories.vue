<template >
    <div class="flex w-full p-2 rounded-full bg-slate-300">
        <div class="flex-1 p-1 w-50">
            <input v-model="keyword" type="text" label="search" name="search" autocomplete="off" class="flex-none w-full px-2 py-1 border-none rounded-full focus-visible:border-transparent focus-visible:outline-0" />
        </div>
        <div class="flex-1 p-1 w-50">
            <it-button type="primary" icon="search" round block @click="search(pagination.current_page)">search</it-button>
        </div>
    </div>

    <div class="w-full p-2 m-2 rounded-lg bg-slate-300 h-fit">
        <div v-for="(value, key) in pagination.data" :key="value.cathegory_id" class="flex w-full py-2 my-2 rounded-full hover:drop-shadow-md bg-slate-50">
            <div class="flex-none w-11/12 pl-3 text-lg">
                {{ value.name }}
            </div>
            <div class="flex-none w-1/12">
                <div class="flex">
                    <it-button icon="edit" lable="edit" @click="addOrEdit( 'Edit', value)"/>
                    <it-button icon="delete" lable="delete" @click="remove(value)"/>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-none w-full">
        <div class="flex-none w-5/12">
            <it-button type="primary" size="big" round block @click="addOrEdit('Add')">Add Cathegory</it-button>

        </div>
        <div class="flex-none w-5/12">
            <!-- <VuePaginationTw 
                class="float-right"
                :totalItems="pagination.last_page"
                :currentPage="pagination.current_page"
                :perPage="pagination.per_page"
                @pageChanged="search"
                :goButton="false"
                styled="centered"
                v-if="!processing"
            /> -->
        </div>
    </div>

    <it-modal v-model="openForm">
        <template #body>
            <div class="signupmodal">
            <h2>{{ action }} Cathegory </h2>
            <it-input labelTop="Cathegory name" type="text" placeholder="Cathegory name" v-model="form.name" />

            <it-button
                block
                size="big"
                type="primary"
                @click="save(form)"
                >Save</it-button
            >
            </div>
        </template>
    </it-modal>

</template>
<script>


export default {
    data() {
        return {
           keyword: '',
           cathegories_data: {},
           pagination:{},
           processing: false,
           openForm: false,
           keyword: '',
           action: 'Add',
           form:{
               name:'',
           }
        }
    },
    methods: {
        async search( selectedPage ) {
             
            this.processing = true;

            if( selectedPage !== undefined ) this.pagination.current_page = selectedPage;
            
            var url = '/api/cathegory/search?page=' + this.pagination.current_page;

            console.log(this.keyword);

            if( this.keyword )
                url+= '&keyword='+ this.keyword;

            await this.$axios.post(url, this.keyword)
            .then( ({ data }) => {
                this.pagination = data;
            } ).catch(({response:{data}})=>{
                alert(data.message)
            }).finally(()=>{
                this.processing = false
            });
        },

        addOrEdit( action, cathegory ){
            this.action = action;
            this.openForm = true;

            if( cathegory !== undefined ) this.form = cathegory;
            
           
        },
        async save( form ){
            
            await this.$axios.post( 'api/cathegory/AddOrUpdate', form )
            .then( ({ data }) => {
                this.openForm = false;
                this.search();
            } ).catch(({response:{data}})=>{
                alert(data.message)
            }).finally(()=>{
                this.processing = false
            });
        },
        remove(cathegory){
            alert( cathegory );
        }
    },
    mounted() {
        this.search()
    }
    
}
</script>
<style >
    
</style>