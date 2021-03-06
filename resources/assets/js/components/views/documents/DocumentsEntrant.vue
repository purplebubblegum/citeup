
<template>
    <div class="documents-entrant">
        <message-box ref="noticeBox" name="success">
            <span slot="title">Penyimpanan Berhasil</span>
            Perubahan telah berhasil disimpan.
            <div slot="buttons" class="text-right">
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </message-box>
        <cloaked-panel ref="header">
            <div class="panel-body">
                <div class="pull-right">
                    <button type="button" class="btn btn-primary" @click="save">Simpan Perubahan</button>
                </div>
                <h1 class="page-title">Kelola Dokumen Saya</h1>
            </div>
            <div class="panel-body">
                <template v-if="approved">Dokumen Anda telah disetujui oleh panitia.</template>
                <template v-else-if="completed">Anda telah melengkapi dokumen-dokumen Anda. Silahkan tunggu persetujuan dari panitia.</template>
                <template v-else>Setiap peserta diwajibkan untuk mengunggah dokumen-dokumen berikut terlebih dahulu agar dapat mengikuti {{ seminar ? 'seminar' : 'penyisihan' }}.</template>
            </div>
        </cloaked-panel>
        </cloaked-panel>
        <div class="row">
            <div class="col-sm-6">
                <cloaked-panel ref="idCards">
                    <div class="panel-body">
                        <h2 class="page-title small-title">
                            <i>Scan</i> Kartu Tanda {{ seminar ? 'Penduduk' : 'Pelajar' }}
                        </h2>
                    </div>
                    <div class="panel-body" v-for="(doc, index) in idCards">
                        <h3 class="subtitle" v-if="multiuser">{{ entry.users.find(item => item.id === doc.user_id).name }}</h3>
                        <file-input :name="'user-'+ doc.id +'-id-card'" :object-id="entry.id" object-type="document" :crop="false" :store-immediately="true" accept="image/*" v-model="idCards[index].file">
                            Unggah Dokumen
                        </file-input>
                    </div>
                </cloaked-panel>
            </div>
            <div class="col-sm-6">
                <cloaked-panel ref="paymentProof">
                    <div class="panel-body">
                        <h2 class="page-title small-title">
                            <i>Scan</i> Bukti Pembayaran Pendaftaran
                        </h2>
                    </div>
                    <div class="panel-body">
                        <file-input :name="'user-'+ user.id +'-payment-proof'" :object-id="entry.id" object-type="document" :crop="false" :store-immediately="true" accept="image/*" v-model="paymentProof.file">
                            Unggah Dokumen
                        </file-input>
                    </div>
                </cloaked-panel>
            </div>
        </div>
    </div>
</template>

<script>

    import _ from 'lodash'
    import { mapState } from 'vuex'
    import Citeup from '../../../citeup'
    import CloakedPanel from '../../misc/CloakedPanel'
    import MessageBox from '../../kits/MessageBox.vue'
    import FileInput from '../../kits/FormPanel/FileInput.vue'
    import DocumentsChecker from '../../mixins/DocumentsChecker'

    const STATES = [
        'user',
    ]

    var counter = 0

    export default {

        mixins: [DocumentsChecker],

        data() {
            return {
                entry: { id: 0, users: []},
                idCards: [],
                paymentProof: {id: 0},
            }
        },

        computed: _.merge(mapState(STATES), {

            saveData() {
                return [ this.paymentProof ].concat(this.idCards)
            },
            
            seminar() {
                return this.user.entry.activity.id === 3
            },

            multiuser() {
                return this.user.entry.activity.id === 1
            },

            completed() {
                return this.entry.users.length > 0 ? this.documentsComplete(this.entry.users) : false
            },

            approved() {
                return this.entry.stage === 1
            }

        }),

        filters: {
            assetify(value) {
                return Citeup.appPath + '/' + value
            },
        },

        created() {
            this.loadDocuments()
        },

        mounted() {
            this.$refs.idCards.cloaking = true
            this.$refs.paymentProof.cloaking = true
            this.prepareComponent()
        },

        watch: {
            idCards(newVal) {
                this.$refs.idCards.cloaking = 
                    ! ((newVal.length === this.entry.users.length) && (this.entry.id > 0))
            },
            paymentProof(newVal) {
                this.$refs.paymentProof.cloaking = newVal.id === 0
            }
        },

        methods: {

            prepareComponent() {
                this.noticeBox = this.$refs.noticeBox
            },

            loadDocuments() {
                Citeup.get('/entries/' + this.user.entry.id).then(response => {
                    this.entry = response.data.data.entry
                    for (let user of response.data.data.entry.users) {
                        this.getDocuments(user.id)
                    }  
                })
            },

            getDocuments(userId) {
                Citeup.get('/documents', {user: userId}).then(response => {
                    let idCardIndex = response.data.data.documents.findIndex(item => item.type === 0)
                    let paymentProofIndex = response.data.data.documents.findIndex(item => item.type === 1)

                    if (idCardIndex >= 0) {
                        this.idCards.push(response.data.data.documents[idCardIndex])
                    }

                    if (paymentProofIndex >= 0 && this.paymentProof.id === 0) {
                        this.paymentProof = response.data.data.documents[paymentProofIndex]
                    }
                })
            },

            save() {
                this.$refs.header.cloaking = true
                for (let doc of this.saveData) {
                    this.putDocument(doc.id, doc)
                }
            },

            putDocument(id, data) {
                Citeup.put('/documents/' + id, data).then(response => {
                    counter++

                    if (counter === this.saveData.length) {
                        this.noticeBox.open()
                        this.$refs.header.cloaking = false
                        counter = 0
                    } 

                })
            },
        },

        components: {
            'file-input': FileInput,
            'message-box': MessageBox,
            'cloaked-panel': CloakedPanel,
        },
    }

</script>
