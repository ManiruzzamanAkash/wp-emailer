<template>
  <button
    :type="type"
    :style="variantStyles"
  >
    <BaseSpinner :status="loading" />
    <span class="button-content">
      <slot />
    </span>
    <!-- slot button content -->
  </button>
</template>

<script>
import BaseSpinner from "../spinner/BaseSpinner.vue";

export default {
    name: "BaseButton",

    components: {
        BaseSpinner,
    },

    props: {
        type: {
            type: String,
            required: false,
            default: "button",
        },
        variant: {
            type: String,
            required: false,
            default: "default",
        },
        loading: {
            type: Boolean,
            required: false,
            default: false,
        },
    },

    computed: {
        variantStyles() {
            let styles = "";

            switch (this.variant) {
            case "primary":
                styles += "background-color:var(--color-primary)";
                break;

            case "error":
                styles += "background-color:var(--color-error)";
                break;

            case "default":
                styles += "background-color:var(--color-secondary)";
                break;

            default:
                break;
            }

            return styles;
        },
    },
};
</script>

<style lang="scss" scoped>
button {
  background: var(--color-primary);
  color: #fff;
  border: 0px solid;
  padding: 10px 20px;
  cursor: pointer;
  transition: all;
  border-radius: 4px;
  display: flex;
  justify-content: center;
  align-items: center;

  &:hover {
    opacity: 0.9;
  }

  .button-content {
    margin-left: 5px;
    margin-right: 5px;
  }
}
</style>