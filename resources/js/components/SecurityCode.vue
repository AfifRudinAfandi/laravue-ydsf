<template>
  <div class="security-code-wrap">
    <label :for="`code-${uuid}`">
      <ul :class="`${theme}-container security-code-container`">
        <li class="field-wrap" v-for="(item, index) in length" :key="index">
          <p class="char-field">{{ value[index] || placeholder }}</p>
        </li>
      </ul>
    </label>
    <input
      ref="input"
      class="input-code"
      @keyup="handleInput($event)"
      v-model="value"
      :id="`code-${uuid}`"
      :name="`code-${uuid}`"
      type="tel"
      :maxlength="length"
      autocorrect="off"
      autocomplete="off"
      autocapitalize="off"
    />
  </div>
</template>

<script>
export default {
  name: "SecurityCode",

  props: {
    length: {
      type: Number,
      default: 4,
    },
    placeholder: {
      type: String,
      default: "",
    },
    theme: {
      type: String,
      default: "block",
    },
  },
  // variables
  data() {
    return {
      value: "",
    };
  },
  computed: {
    uuid() {
      return Math.random().toString(36).substring(3, 8);
    },
  },
  methods: {
    hideKeyboard() {
      document.activeElement.blur();
      this.$refs.input.blur();
    },
    handleSubmit() {
      this.$emit("input", this.value);
    },
    handleInput(e) {
      if (e.target.value.length >= this.length) {
        this.hideKeyboard();
      }
      this.handleSubmit();
    },
  },
};
</script>

<style scoped lang="scss">
.security-code-wrap {
  display: flex;
  align-items: center;
  justify-content: center;
}

.security-code-container {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  margin-bottom: 38px;
  padding-left: 0;
  .field-wrap {
    cursor: text;
    list-style: none;
    display: block;
    width: 44px;
    border: none;
    margin-right: 12px;
    border-bottom: 2px solid #909aad;
    text-align: center;
    font-size: 24px;
    color: #2d386e;
    .char-field {
      line-height: 50px;
      font-style: normal;
      font-size: 24px;
      margin-bottom: 0;
      min-height: 50px;
    }
  }
  .field-wrap:nth-last-child(1) {
    margin-right: 0;
  }
  .field-wrap:focus,
  .field-wrap:active {
    border-color: #48b349;
  }
}
.input-code {
  position: absolute;
  left: -9999px;
  top: -9999px;
}
</style>
