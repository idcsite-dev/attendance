$.extend(window.Parsley.options, {
  focus: "first",
  excluded:
    "input[type=button], input[type=submit], input[type=reset], .search, .ignore",
  triggerAfterFailure: "change blur",
  errorsContainer: function (element) {},
  trigger: "change",
  successClass: "is-valid",
  errorClass: "is-invalid",
  classHandler: function (el) {
    return el.$element.closest(".form-group");
  },
  errorsContainer: function (el) {
    return el.$element.closest(".form-group");
  },
  errorsWrapper: '<div class="parsley-error"></div>',
  errorTemplate: "<span></span>",
});

Parsley.on("field:validated", function (el) {
  var elNode = $(el)[0];
  if (elNode && !elNode.isValid()) {
    var requiredValResult = elNode.validationResult.filter(function (vr) {
      return vr.assert.name === "required";
    });
    if (requiredValResult.length > 0) {
      var fieldNode = $(elNode.element);
      var formGroupNode = fieldNode.closest(".form-group");
      var lblNode = formGroupNode.find(".form-label:first");
      if (lblNode.length > 0) {
        var lblText = lblNode.text();
        lblText = lblText.replace(":", "");
        var spanNode = lblNode.find("span");
        if (spanNode.length > 0) {
          lblText = lblText.replace("*", ""); // Remove '*' character
        }
        // Get the element's tag name
        var tagName = fieldNode.prop("tagName").toLowerCase();

        // Determine the error message based on the tag name
        var errorMessage;
        if (tagName === "input") {
          if (fieldNode.attr("type") === "file") {
            errorMessage = lblText + " belum dipilih.";
          } else {
            errorMessage = lblText + " wajib diisi.";
          }
        } else if (tagName === "select") {
          errorMessage = lblText + " wajib dipilih.";
        } else {
          errorMessage = lblText + " wajib diisi.";
        }

        // Change the error message
        var errorNode = formGroupNode.find(
          "div.parsley-error span[class*=parsley-]"
        );
        if (errorNode.length > 0 && errorMessage) {
          errorNode.html(errorMessage);
        }
      }
    }
  }
});

Parsley.addValidator("matchPassword", {
  requirementType: "string",
  validateString: function (value, requirement) {
    // Get the value of the "password" field
    var password = $("#" + requirement).val();

    // Compare the "password" and "confirm password" fields
    return value === password;
  },
  messages: {
    en: "Password tidak sama.",
    id: "Password tidak sama.",
  },
});
