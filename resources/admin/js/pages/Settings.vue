<script setup>
import { ref, computed } from "vue";
import axios from "axios";
import { forEach } from "lodash";

const options = ref(window.wpvueplugin_object?.options);
const settingsEndpoint = computed(
    () => window.wpvueplugin_object?.settings_endpoint
);

const alertMsg = ref("");
const showAlert = ref(false);
const isSuccess = ref(false);
const isSaving = ref(false);

function submitForm() {
    isSaving.value = true;

    let data = {};

    forEach(options.value, function (obj, key) {
        data[key] = obj.value;
    });

    axios
        .post(settingsEndpoint.value, data)
        .then((res) => {
            isSuccess.value = true;
            alertMsg.value = "Settings saved.";
        })
        .catch((err) => {
            isSuccess.value = false;
            alertMsg.value = "Could not save settings.";
        })
        .finally(() => {
            isSaving.value = false;
            showAlert.value = true;
        });
}
</script>

<template>
    <div
        class="notice settings-error is-dismissible"
        :class="[isSuccess ? 'notice-success' : 'notice-error']"
        v-if="showAlert"
    >
        <p><strong v-text="alertMsg"></strong></p>
        <button
            @click.prevent="showAlert = false"
            type="button"
            class="notice-dismiss"
        >
            <span class="screen-reader-text">Dismiss this notice.</span>
        </button>
    </div>

    <form @submit.prevent="submitForm()">
        <table class="form-table">
            <tbody>
                <tr v-for="(option, key) in options" :key="key">
                    <th scope="row">
                        <label :for="key" v-text="option.name"></label>
                    </th>
                    <td>
                        <input
                            :name="key"
                            :type="option.type"
                            :id="key"
                            v-model="option.value"
                            class="regular-text"
                        />

                        <p
                            class="description"
                            v-if="option.desc"
                            v-text="option.desc"
                        ></p>
                    </td>
                </tr>
            </tbody>
        </table>

        <p class="submit">
            <input
                type="submit"
                name="submit"
                id="submit"
                class="button button-primary"
                :value="isSaving ? 'Saving...' : 'Save Changes'"
                :disabled="isSaving"
            />
        </p>
    </form>
</template>
