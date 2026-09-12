// NSFWhen.com — Vue 3 Non-SFC Age Gate Component
(function() {
  if (typeof Vue === 'undefined') return;

  const { createApp, ref } = Vue;

  window.initAgeGate = function(containerId) {
    const app = createApp({
      setup() {
        const isVerified = ref(localStorage.getItem('nsfwhen_age_verified') === 'true');
        const checkAge = ref(false);
        const checkNotice = ref(false);

        function confirmAge() {
          if (!checkAge.value || !checkNotice.value) {
            alert('Please check both declarations to proceed.');
            return;
          }
          localStorage.setItem('nsfwhen_age_verified', 'true');
          isVerified.value = true;
        }

        function leave() {
          window.location.href = 'https://www.google.com';
        }

        return {
          isVerified,
          checkAge,
          checkNotice,
          confirmAge,
          leave
        };
      },
      template: `
        <div v-if="!isVerified" class="modal-backdrop" style="z-index: 9999;">
          <div class="modal-dialog" style="max-width: 440px;">
            <div class="modal-header">
              <span>STEP 0 — FIRST VISIT</span>
            </div>
            <div class="modal-body">
              <div style="font: 700 20px/1.2 'Source Serif 4', Georgia, serif; color: #f2f4f6;">
                Before you continue
              </div>
              <div style="font-size: 12px; line-height: 1.6; color: #b4bcc4;">
                NSFWhen catalogues sexual content in films as <b style="color: #e6e8eb;">text and timestamps only</b>. It hosts no images, clips or stills of that content. The category language is still explicit, so the site is intended for adults.
              </div>

              <div style="display: flex; flex-direction: column; gap: 10px; padding: 12px; background: #101317; border: 1px solid #22262c; border-radius: 3px;">
                <label style="display: flex; align-items: flex-start; gap: 10px; font-size: 11px; color: #c3cad1; cursor: pointer;">
                  <input type="checkbox" v-model="checkAge" style="margin-top: 2px; accent-color: #4a72a0;">
                  <span>I am 18 years of age or older.</span>
                </label>
                <label style="display: flex; align-items: flex-start; gap: 10px; font-size: 11px; color: #c3cad1; cursor: pointer;">
                  <input type="checkbox" v-model="checkNotice" style="margin-top: 2px; accent-color: #4a72a0;">
                  <span>I understand this site describes sexual content in text form and does not host any such imagery.</span>
                </label>
              </div>

              <div style="display: flex; gap: 10px; margin-top: 4px;">
                <button @click="confirmAge"
                        :disabled="!checkAge || !checkNotice"
                        class="btn btn-primary"
                        style="flex: 1; justify-content: center; padding: 10px; opacity: (!checkAge || !checkNotice) ? 0.5 : 1;">
                  I am 18 or older — enter
                </button>
                <button @click="leave" class="btn btn-secondary" style="padding: 10px 14px;">
                  Leave
                </button>
              </div>

              <div style="font-size: 10px; color: #6a737c; line-height: 1.5;">
                We store a single local flag so you are not asked again on this device. No account required to browse.
              </div>
            </div>
          </div>
        </div>
      `
    });

    app.mount(containerId);
  };
})();
