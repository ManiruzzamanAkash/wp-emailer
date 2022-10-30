<script setup>
import { __ } from '@wordpress/i18n';
</script>

<template>
  <div class="settings-form">
    <form
      method="post"
      @submit="onSubmit"
    >
      <!-- Section 1 -->
      <div class="section">
        <BaseCard
          :header-title="__('General', 'wp-emailer')"
          :header-description="__('Change general contents for the settings', 'wp-emailer')"
        >
          <template #content>
            <InputSection
              type="number"
              :label="__('Number of rows', 'wp-emailer')"
              name="numrows"
              :hint="__('How many rows will be displayed on the table', 'wp-emailer')"
              :value="settings?.numrows"
              :required="true"
              :on-change="changeInput"
              :min="1"
              :max="5"
            />

            <InputSection
              type="switch"
              :label="__('Show human readable date', 'wp-emailer')"
              name="humandate"
              :value="settings?.humandate"
              :hint="__('If the date in the table will be displayed as a human readable format or a timestamp', 'wp-emailer')"
              :required="false"
              :on-change="changeInput"
            />
          </template>
        </BaseCard>
      </div>

      <!-- Section 2 -->
      <div class="section">
        <BaseCard
          :header-title="__('Email', 'wp-emailer')"
          :header-description="__('Change your email settings', 'wp-emailer')"
        >
          <template #content>
            <InputSection
              type="email"
              :label="__('Emails', 'wp-emailer')"
              name="emails"
              :on-change="changeInput"
            >
              <template #input-content>
                <BaseButton
                  v-if="!emailsData.length"
                  :onclick="appendEmail"
                  type="button"
                  variant="default"
                  class="email-append-button"
                >
                  + {{ __('Add New', 'wp-emailer') }}
                </BaseButton>

                <div
                  v-for="(email, index) in emailsData"
                  :key="index"
                >
                  <div class="mt-20 flex">
                    <BaseInput
                      type="email"
                      :name="`emails_${index}`"
                      :value="email"
                      :on-change="(input) => changeEmailInput(input, index)"
                    />
                    <BaseButton
                      v-if="emailsData.length < 5 && !index"
                      :onclick="appendEmail"
                      type="button"
                      variant="default"
                      class="email-append-button"
                    >
                      +
                    </BaseButton>

                    <BaseButton
                      type="button"
                      :onclick="() => deleteEmail(index)"
                      variant="error"
                      class="email-append-button"
                    >
                      -
                    </BaseButton>
                  </div>
                </div>
              </template>
            </InputSection>
          </template>
        </BaseCard>
      </div>
    </form>
  </div>
</template>

<script>
import BaseCard from "../card/BaseCard.vue";
import BaseButton from "../../components/button/BaseButton.vue";
import InputSection from "../../components/input/InputSection.vue";
import BaseInput from "../../components/input/BaseInput.vue";

export default {
    name: "SettingForm",

    components: {
        BaseCard,
        BaseButton,
        InputSection,
        BaseInput
    },

    props: {
        change: {
            type: Function,
            required: true,
        },
        settings: {
            type: Object,
            required: true,
        }
    },

    data() {
        return {
            emailsData: [...this.settings.emails]
        };
    },

    methods: {
        changeInput(input) {
            this.change(input);
        },

        changeEmailInput(input, index) {
            this.emailsData[index] = input.value;
            this.saveEmails();
        },

        appendEmail() {
            this.emailsData.push('');
        },

        deleteEmail(index) {
            this.emailsData.splice(index, 1);
            this.saveEmails();
        },

        saveEmails() {
            this.change({
                key: 'emails',
                value: !this.emailsData.length ? '' : this.emailsData
            });
        },

        onSubmit(e) {
            e.preventDefault();
            // We don't make full-form submission's here.
            // We've added single column wise saving on change-input.
        },
    },
};
</script>

<style lang="scss" scoped>
.settings-form {
  .section-save {
    margin-top: 40px;
  }
  .email-append-button {
    margin-left: 20px;
    padding: 10px 10px;
  }
}
</style>