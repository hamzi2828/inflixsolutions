<template>
  <component v-bind:is="tag">{{ formattedCurrencyValue }}</component>
</template>
<script>
import { mapState } from "vuex";
export default {
  name: "Currency",
  props: {
    amount: {
      type: Number,
      required: false,
    },
    tag: {
      type: String,
      required: false,
      default: "span",
    },
  },
  data() {
    return {
      defaultCurrency: JSON.parse(localStorage.getItem("default_currency")),
      user_selected_currency: JSON.parse(localStorage.getItem("currency")),
    };
  },
  computed: mapState({
    formattedCurrencyValue() {
      let converted_amount = 0;
      if (typeof this.amount == "undefined") {
        converted_amount = 0;
      } else {
        converted_amount = this.amount;
      }
      converted_amount =
        converted_amount != 0
          ? (this.amount * this.user_selected_currency.conversion_rate) /
            this.defaultCurrency.conversion_rate
          : 0;
      converted_amount = parseFloat(converted_amount).toFixed(
        this.user_selected_currency.number_of_decimal
      );
      var amount_parts = converted_amount.toString().split(".");
      const numberPart = amount_parts[0];
      const decimalPart = amount_parts[1];
      const thousands = /\B(?=(\d{3})+(?!\d))/g;
      let final_amount =
        numberPart.replace(
          thousands,
          this.user_selected_currency.thousand_separator
        ) +
        (decimalPart
          ? this.user_selected_currency.decimal_separator + decimalPart
          : "");
      if (this.user_selected_currency.position == 1) {
        return this.user_selected_currency.symbol + "" + final_amount;
      }
      if (this.user_selected_currency.position == 2) {
        return final_amount + "" + this.user_selected_currency.symbol;
      }
      if (this.user_selected_currency.position == 3) {
        return this.user_selected_currency.symbol + " " + final_amount;
      }
      if (this.user_selected_currency.position == 4) {
        return final_amount + " " + this.user_selected_currency.symbol;
      }
    },
  }),
};
</script>