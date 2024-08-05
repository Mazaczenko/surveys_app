<template>
  <guest-layout>
    <Head title="Ankieta" />
    <form-wizard
      v-if="!completed"
      @on-complete="onComplete"
      @on-error="handleErrorMessage"
      shape="circle"
      color="gray"
      error-color="#e74c3c"
      back-button-text="wróć"
      next-button-text="dalej"
      finish-button-text="zakończ"
    >
      <tab-content
        :title="survey.questions[0].value"
        :customIcon="`<img src='${iconsSteps[1]}' width='35px' />`"
        :before-change="validateFirstStep"
      >
        <n-space vertical>
          <n-input
            v-model:value="filled.sources"
            type="textarea"
            placeholder="Twoja odpowiedź"
            :autosize="{ minRows: 3 }"
            style="max-width: 100%; min-width: 50%; padding-top: 2rem"
          />
        </n-space>
      </tab-content>

      <tab-content
        :title="survey.questions[1].value"
        :customIcon="`<img src='${iconsSteps[2]}' width='35px' />`"
        :before-change="validateSecondStep"
        class="text-center lg:pb-10"
      >
        <div class="flex justify-center">
          <n-select
            placeholder="Wybierz"
            v-model:value="filled.color"
            :options="filled.colorOptions"
            style="max-width: 50%; padding-top: 2rem"
          />
        </div>
      </tab-content>

      <tab-content
        :title="survey.questions[2].value"
        :customIcon="`<img src='${iconsSteps[3]}' width='35px' />`"
        :before-change="validateLastStep"
      >
        <div class="rating-container">
            <template v-for="option in filled.colorOptions" :key="option.value">
                <div class="rating-item">
                    <span class="option-label">{{ option.label }}</span>
                    <n-rate
                        color="#4fb233"
                        v-model:value="option.rate"
                    />
                </div>
            </template>
        </div>
      </tab-content>

      <div v-if="errorMsg">
        <span class="error">{{ errorMsg }}</span>
      </div>
    </form-wizard>
  </guest-layout>
</template>

<script>
  import { Inertia } from '@inertiajs/inertia';
  import { FormWizard, TabContent } from "vue3-form-wizard";
  import GuestLayout from '@/Layouts/GuestLayout.vue';
  import { Head } from '@inertiajs/vue3'
  import { NInput, NSelect, NSpace, NRate, NDivider } from 'naive-ui';
  import "vue3-form-wizard/dist/style.css";

  export default {
    name: "AttemptCreate",
    components: {
      GuestLayout, Head, FormWizard, TabContent, NInput, NSelect, NSpace, NRate, NDivider
    },
    props: {
      attempt: {
        type: Object,
      },
      survey: {
        type: Object,
      }
    },
    data() {
      return {
        errorMsg: '',
        filled: {
          sources: '',
          color: null,
          colorOptions: [],
          step: 1,
          attempt_id: this.attempt.id,
        },

        completed: false,
        iconsSteps: {
           1: "/icons/step-one.svg",
           2: "/icons/step-two.svg",
           3: "/icons/step-three.svg"
        }
      }
    },
    methods: {
      onComplete() {
        this.completed = true;
      },
      saveStep(step) {
        this.filled.step = step;

        Inertia.post('/progress/store', this.filled, {
          onSuccess: (response) => {
            console.log('Success:', response);
          },
          onError: (errors) => {
            console.error('Error:', errors);
          }
        });
      },
      handleErrorMessage(err) {
        this.errorMsg = err;
      },
      validateStep(condition, errorMessage, step = null) {
        return new Promise((resolve, reject) => {
          if (condition) {

            resolve(true);

            if (step) {
              this.saveStep(step)
            };

          } else {
            reject(errorMessage);
          }
        });
      },
      validateFirstStep() {
        const condition = this.filled.sources.length >= 20;
        return this.validateStep(condition, "Odpowiedź musi mieć przynajmniej 20 znaków", 1);
      },
      validateSecondStep() {
        const condition = this.filled.color !== null;
        return this.validateStep(condition, "Wybierz swój ulubiony kolor", 2);
      },
      validateLastStep() {
        const condition = this.allColorsWhereRanked();
        console.log(condition);
        return this.validateStep(condition, "Oceń wszystkie kolory",3);
      },
      prepareOptions(){
        this.filled.colorOptions = this.survey.questions[1].options.map(option => ({
          label: option.value,
          value: option.id,
          disabled: false,
          rate: null
        }));
      },
      allColorsWhereRanked() {
        return this.filled.colorOptions.every(option => option.rate !== null);
      }
    },
    mounted() {
      this.prepareOptions()
    }
  }
</script>

<style scoped>
@import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css");
span.error {
  color: #e74c3c;
  font-size: 20px;
  display: flex;
  justify-content: center;
}

.rating-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    width: 100%;
}

.rating-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    max-width: 600px;
    padding: 0 1rem;
}

.option-label {
    text-align: left;
}

.n-rate {
    text-align: right;
}
</style>
