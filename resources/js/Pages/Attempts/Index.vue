<template>
  <guest-layout>
      <Head title="Lista Ankiet" />
      <div class="bg-white rounded-md shadow overflow-x-auto">
        <h1 class="pb-4 pt-6 px-6 font-bold uppercase">Uzupełnione Ankiety</h1>

        <table class="w-full">
          <thead>
            <tr class=" font-bold text-left">
              <th class="pb-4 pt-6 px-6">ID</th>
              <th class="pb-4 pt-6 px-6" v-for="question in survey.questions" :key="question.id">
                {{ question.value }}
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(attempt, index) in attempts.data" :key="index" class="hover:bg-gray-100 focus-within:bg-gray-100 text-center">
              <td>{{ attempt.id }}</td>
              <!-- Render other answers in their respective columns -->
              <template v-for="(answer, idx) in attempt.answers" :key="answer.id">
                <td v-if="answer.type !== 'numeric'" style="max-width: 150px">
                  <template v-if="answer.type === 'text'">
                    {{ answer.text }}
                  </template>
                  <template v-if="answer.type === 'option'">
                    {{ answer.option.value }}
                  </template>
                </td>
              </template>
              <!-- Ensure the numeric answers column is always the last column -->
              <td class="text-start">
                <ul>
                  <li v-for="(item, idx) in getNumericAnswers(attempt.answers)" :key="idx">
                    {{ item }}
                  </li>
                </ul>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <pagination class="mt-6" :links="attempts.links" />
  </guest-layout>
</template>

<script>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Pagination from '@/Components/Pagination.vue'
import { Head } from '@inertiajs/vue3';

export default {
  name: "AttemptsIndex",
  components: {
      GuestLayout,
      Pagination,
      Head
  },
  props: {
    survey: {
      type: Object,
      required: true
    },
    attempts: {
      type: Object,
    }
  },
  methods: {
    getNumericAnswers(answers) {
      // Filter answers to get only numeric types and format them
      return answers
        .filter(answer => answer.type === 'numeric')
        .map(answer => `${answer.option.value} - ${answer.numeric}`);
    }
  },
}
</script>


<style scoped>

</style>
