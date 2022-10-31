<template>
  <div class="settings-page">
    <SettingFormLoading v-if="isSettingsLoading" />

    <SettingForm
      v-if="!isSettingsLoading"
      :default="settings"
      :change="onChangeInput"
      :settings="settings"
    />
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import { debounce } from "debounce";
import { validateSettings } from "../utils/validation";
import SettingForm from '../components/settings/SettingForm.vue';
import SettingFormLoading from "../components/settings/SettingFormLoading.vue";

export default {
    name: "SettingPage",

    components: {
        SettingForm,
        SettingFormLoading,
    },

    data() {
        return {
            currentInput: {},
        };
    },

    computed: { ...mapGetters(["alert", "isSettingsSaving", "isSettingsLoading", "settings"]) },

    watch: {
        currentInput: debounce(function(val) {
            this.storeSettings(val);
        }, 500)
    },

    methods: {
        ...mapActions(["storeSettings", "setAlert", "hideAlert"]),

        onChangeInput(input) {
            // Validate client side.
            const validate = validateSettings(input);

            if (!validate.valid) {
                this.setAlert({
                    message  : validate.message,
                    type     : 'error'
                });
                return;
            } else {
                if (alert.isVisible) {
                    this.hideAlert();
                }
            }

            this.currentInput = input;
        },
    },
};
</script>