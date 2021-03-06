
<template>
    <div id="entrants-index">
        <message-box ref="confirmation" name="confirmation-box" backdrop="static" :dismissable="false">
            <template slot="title">{{ confirmation.disqualify ? 'Diskualifikasi' : 'Aktifkan' }} Peserta</template>
            <p>Anda akan {{ confirmation.disqualify ? 'mendiskualifikasi' : 'mengaktifkan kembali' }} peserta {{ confirmation.entry.activity.name }} dengan nama "{{ confirmation.entry.name }}".</p>
            <p>Peserta yang terlibat:</p>
            <ul><li v-for="entrant in confirmation.entry.users">{{ entrant.name }}</li></ul>
            <template slot="buttons">
                <button type="button" class="btn btn-default" data-dismiss="modal" @click="cancelConfirm">Batal</button>
                <button type="button" class="btn btn-primary" @click="confirm(getEntries)">OK</button>
            </template>
        </message-box>
        <data-panel ref="dataPanel" v-model="entries" :expandable="true" :deletable="true">
            Daftar Peserta
            <data-panel-addon slot="control">
                <radio-button name="activity" :list="activities" v-model="selected">
                    <template slot="list" scope="props">{{ props.data }}</template>
                </radio-button>
            </data-panel-addon>
            <template slot="list" scope="props">
                <data-panel-list-item :id="props.data.id" :update="{ name: 'Peserta.Sunting', params: { id: props.data.id }}">
                    <template slot="title">
                        {{ props.data.name }} <small>{{ props.data.activity.name }}</small>
                        <div class="pull-right">
                            <span v-if="props.data.stage === 1" class="text-success">Dokumen peserta ini sudah disetujui.</span>
                            <span v-else-if="documentsComplete(props.data.users)" class="text-primary">Peserta ini sudah melengkapi dokumennya.</span>
                            <span v-else-if="hasPaid(props.data.users)" class="text-info">Peserta ini sudah mengirim bukti pembayaran.</span>
                            <template v-else>Peserta ini belum melengkapi dokumennya.</template> 
                        </div>
                    </template>
                    <p class="text-danger" v-if="props.data.status === 0">
                        Peserta ini didiskualifikasi.
                    </p>
                    <p>
                        <small class="text-muted">
                            Terdaftar sejak {{ props.data.created_at | normalize }}.
                        </small>
                    </p>
                    <template slot="actions">
                        <li role="separator" class="divider"></li>
                        <router-link tag="li" :to="{ name: 'Peserta.Lihat', params: { id: props.data.id }}"><a>Lihat Detail</a></router-link>
                        <router-link v-if="documentsComplete(props.data.users)" tag="li" :to="{ name: 'Peserta.Dokumen', params: { id: props.data.id }}"><a>Lihat Dokumen</a></router-link>
                        <template v-if="props.data.activity.id !== 3">
                            <li role="separator" class="divider"></li>
                            <li v-if="props.data.status === 0"><a href="#" @click.prevent="preConfirm(props.data, false)">Aktifkan</a></li>
                            <li v-else-if="props.data.status === 1"><a href="#" @click.prevent="preConfirm(props.data, true)">Diskualifikasi</a></li>
                        </template>
                        <li v-if="documentsComplete(props.data.users) && props.data.stage !== 1"><a href="#" @click.prevent="approve(props.data.id)">Setujui Dokumen</a></li>
                    </template>
                </data-panel-list-item>
            </template>
        </data-panel>
    </div>
</template>

<script>

    import _ from 'lodash'
    import moment from 'moment-timezone'
    import Citeup from '../../../citeup'
    import UsersMixin from './UsersMixin'
    import MessageBox from '../../kits/MessageBox.vue'
    import EntrantDisqualifier from './EntrantDisqualifier'
    import DataPanel from '../../kits/DataPanel/DataPanel.vue'
    import DataPanelAddon from '../../kits/DataPanel/Addon.vue'
    import DocumentsChecker from '../../mixins/DocumentsChecker'
    import DataPanelListItem from '../../kits/DataPanel/ListItem.vue'
    import RadioButton from '../../kits/FormPanel/RadioButton/UngroupedList.vue'

    const ACTIVITIES = {
        0: 'Semua',
        1: 'Lomba Logika',
        2: 'Lomba Desain',
        3: 'Seminar IT',
    }

    export default {

        mixins: [UsersMixin, EntrantDisqualifier, DocumentsChecker],

        props: {
            activity: {
                type: Number,
                default: 0,
            },
        },

        data() {
            return {
                entries: [],
                dataPanel: null,
                activities: ACTIVITIES,
                selected: this.activity,
            }
        },

        filters: {

            normalize(value) {
                return moment(value).format('DD MMM, HH:mm')
            },

            assetify(value) {
                return Citeup.appPath + '/' + value
            },

        },

        watch: {
            selected(newVal) {
                this.getEntries(newVal)
            },
        },

        created() {
            this.getEntries()
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            getEntries(activity = 0) {

                let data = {}

                data.with = 'users.documents,activity'

                if (activity > 0) {
                    data.activity = activity
                }

                Citeup.get('/entries', data).then(
                    response => this.entries = response.data.data.entries
                )
            },

            prepareComponent() {
                this.dataPanel = this.$refs.dataPanel
                this.referConfirmationBox(this.$refs.confirmation)
            },

            approve(id) {
                Citeup.post('/entrants/' + id + '/approve').then(response => {
                    this.getEntries()
                })
            },

        },

        components: {
            'data-panel': DataPanel,
            'message-box': MessageBox,
            'radio-button': RadioButton,
            'data-panel-addon': DataPanelAddon,
            'data-panel-list-item': DataPanelListItem,
        }

    }

</script>
