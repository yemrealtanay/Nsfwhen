// NSFWhen.com — Vue 3 Non-SFC Timeline Scrubber Component
(function() {
  if (typeof Vue === 'undefined') {
    console.error('Vue 3 is not loaded');
    return;
  }

  const { createApp, ref, computed } = Vue;

  window.initTimeline = function(containerId, initialConfig) {
    const app = createApp({
      setup() {
        const film = ref(initialConfig.film);
        const scenes = ref(initialConfig.scenes || []);
        const runtimeSeconds = ref(initialConfig.runtimeSeconds || 1);
        const ticks = ref(initialConfig.ticks || []);
        const gridLines = ref(initialConfig.gridLines || []);
        const csrfToken = ref(initialConfig.csrfToken || '');
        const isAuthenticated = ref(initialConfig.isAuthenticated || false);

        // UI states
        const activeCategoryFilter = ref('all');
        const showUnverified = ref(true);
        const activeSceneHover = ref(null);
        const showAddModal = ref(false);
        const showReportModal = ref(false);
        const reportTarget = ref(null);
        const reportReason = ref('');

        // New mark form
        const newStart = ref('00:00:00');
        const newEnd = ref('00:01:00');
        const newCategory = ref('sex_scene');
        const isSubmitting = ref(false);
        const formError = ref('');

        const filteredScenes = computed(() => {
          return scenes.value.filter(s => {
            if (!showUnverified.value && s.status !== 'verified') {
              return false;
            }
            if (activeCategoryFilter.value !== 'all' && s.category !== activeCategoryFilter.value) {
              return false;
            }
            return true;
          });
        });

        function parseToSeconds(timeStr) {
          const parts = String(timeStr).trim().split(':').map(Number);
          if (parts.length === 3) return (parts[0] * 3600) + (parts[1] * 60) + parts[2];
          if (parts.length === 2) return (parts[0] * 60) + parts[1];
          if (parts.length === 1) return parts[0];
          return 0;
        }

        function formatSeconds(sec) {
          const h = Math.floor(sec / 3600);
          const m = Math.floor((sec % 3600) / 60);
          const s = sec % 60;
          return `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
        }

        async function submitScene() {
          formError.value = '';
          const startSec = parseToSeconds(newStart.value);
          const endSec = parseToSeconds(newEnd.value);

          if (endSec <= startSec) {
            formError.value = 'End time must be greater than start time.';
            return;
          }

          isSubmitting.value = true;
          try {
            const resp = await fetch(`/film/${film.value.id}/scenes`, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken.value
              },
              body: JSON.stringify({
                start_time: startSec,
                end_time: endSec,
                category: newCategory.value
              })
            });

            const data = await resp.json();
            if (!resp.ok) {
              formError.value = data.message || 'Failed to submit scene mark.';
              return;
            }

            // Calculate position for timeline
            data.scene.left = ((data.scene.start_seconds / runtimeSeconds.value) * 100).toFixed(2) + '%';
            data.scene.width = Math.max(0.8, ((data.scene.duration_seconds / runtimeSeconds.value) * 100)).toFixed(2) + '%';
            scenes.value.push(data.scene);
            scenes.value.sort((a, b) => a.start_seconds - b.start_seconds);

            showAddModal.value = false;
            newStart.value = '00:00:00';
            newEnd.value = '00:01:00';
          } catch (err) {
            formError.value = 'Network error submitting scene.';
          } finally {
            isSubmitting.value = false;
          }
        }

        async function voteScene(scene, voteType) {
          if (!isAuthenticated.value) {
            window.location.href = '/login';
            return;
          }

          try {
            const resp = await fetch(`/scenes/${scene.id}/vote`, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken.value
              },
              body: JSON.stringify({ vote_type: voteType })
            });

            if (resp.ok) {
              const data = await resp.json();
              scene.user_vote = data.user_vote;
              scene.confirm_votes = data.confirm_votes;
              scene.dispute_votes = data.dispute_votes;
            }
          } catch (err) {
            console.error('Vote error:', err);
          }
        }

        function openReport(scene) {
          if (!isAuthenticated.value) {
            window.location.href = '/login';
            return;
          }
          reportTarget.value = scene;
          reportReason.value = '';
          showReportModal.value = true;
        }

        async function submitReport() {
          if (!reportReason.value.trim()) return;

          try {
            const resp = await fetch('/reports', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken.value
              },
              body: JSON.stringify({
                type: 'scene',
                id: reportTarget.value.id,
                reason: reportReason.value
              })
            });

            if (resp.ok) {
              showReportModal.value = false;
              alert('Report submitted for editor review.');
            }
          } catch (err) {
            alert('Failed to submit report.');
          }
        }

        return {
          film,
          scenes,
          filteredScenes,
          ticks,
          gridLines,
          activeCategoryFilter,
          showUnverified,
          activeSceneHover,
          showAddModal,
          showReportModal,
          reportTarget,
          reportReason,
          newStart,
          newEnd,
          newCategory,
          isSubmitting,
          formError,
          submitScene,
          voteScene,
          openReport,
          submitReport,
          formatSeconds
        };
      },
      template: `
        <div class="timeline-component" style="display: flex; flex-direction: column; gap: 14px;">
          <!-- Controls & Legend -->
          <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; padding: 10px 14px; background: #121519; border: 1px solid #22262c; border-radius: 3px;">
            <div style="display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
              <span style="font: 500 9px/1 'IBM Plex Mono', monospace; color: #767e87; letter-spacing: .08em;">LEGEND</span>
              <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 11px; color: #b4bcc4;">
                <span style="width: 14px; height: 8px; border-radius: 1px; background: #e05a5a;"></span>
                Sex scene
              </span>
              <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 11px; color: #b4bcc4;">
                <span style="width: 14px; height: 8px; border-radius: 1px; background: #d98a4a;"></span>
                Nudity
              </span>
              <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 11px; color: #b4bcc4;">
                <span style="width: 14px; height: 8px; border-radius: 1px; background: #d9a441;"></span>
                Suggestive
              </span>
              <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 11px; color: #767e87;">
                <span style="width: 14px; height: 8px; border-radius: 1px; border: 1px dashed #767e87; background: transparent;"></span>
                Community / Unverified
              </span>
            </div>

            <div style="display: flex; align-items: center; gap: 10px;">
              <label style="display: flex; align-items: center; gap: 6px; font-size: 11px; color: #98a0a8; cursor: pointer;">
                <input type="checkbox" v-model="showUnverified" style="accent-color: #4a72a0;">
                Show unverified marks
              </label>
              <button @click="showAddModal = true" class="btn btn-primary" style="padding: 6px 11px; font-size: 11px;">
                + Add scene
              </button>
            </div>
          </div>

          <!-- The Scrubber Bar Container -->
          <div style="background: #111418; border: 1px solid #262b31; border-radius: 3px; padding: 22px 18px 12px; position: relative;">
            
            <!-- Tooltip Hover Display -->
            <div v-if="activeSceneHover" style="position: absolute; top: 3px; left: 18px; font: 500 11px/1 'IBM Plex Mono', monospace; color: #e6e8eb; display: flex; align-items: center; gap: 8px;">
              <span :style="{ background: activeSceneHover.color, width: '7px', height: '7px', borderRadius: '1px' }"></span>
              <span>{{ activeSceneHover.range }}</span>
              <span style="color: #98a0a8;">({{ activeSceneHover.duration }})</span>
              <span style="text-transform: uppercase; color: #a9cdf0; letter-spacing: 0.05em;">{{ activeSceneHover.category_label }}</span>
              <span v-if="activeSceneHover.is_verified" style="color: #7cc08a; font-size: 9px; padding: 2px 4px; border: 1px solid #2e4a36; border-radius: 2px; background: #16211a;">VERIFIED</span>
              <span v-else style="color: #98a0a8; font-size: 9px; padding: 2px 4px; border: 1px solid #303740; border-radius: 2px; background: #1b1f24;">UNVERIFIED</span>
            </div>

            <!-- Bar track -->
            <div style="position: relative; height: 32px; background: #181c22; border-radius: 2px; overflow: hidden; border: 1px solid #2a3138;">
              <!-- Grid lines -->
              <span v-for="(g, idx) in gridLines" :key="'g-'+idx"
                    :style="{ position: 'absolute', top: 0, bottom: 0, width: '1px', background: '#22262c', left: g.left }">
              </span>

              <!-- Plotted Scene Segments -->
              <div v-for="scene in filteredScenes" :key="scene.id"
                   @mouseenter="activeSceneHover = scene"
                   @mouseleave="activeSceneHover = null"
                   :style="{
                     position: 'absolute',
                     top: '3px',
                     bottom: '3px',
                     left: scene.left,
                     width: scene.width,
                     background: scene.is_verified ? scene.color : 'transparent',
                     border: scene.is_verified ? 'none' : '1px dashed ' + scene.color,
                     borderRadius: '1px',
                     cursor: 'pointer',
                     zIndex: 10,
                     minWidth: '4px'
                   }"
                   :title="scene.range + ' (' + scene.category_label + ')'">
              </div>
            </div>

            <!-- Ticks under bar -->
            <div style="position: relative; height: 18px; margin-top: 5px;">
              <span v-for="(t, idx) in ticks" :key="'t-'+idx"
                    :style="{
                      position: 'absolute',
                      top: '2px',
                      left: t.left,
                      transform: 'translateX(-50%)',
                      font: '400 9px/1 IBM Plex Mono, monospace',
                      color: '#5c646d'
                    }">
                {{ t.label }}
              </span>
            </div>
          </div>

          <!-- Marks Table -->
          <div style="background: #111418; border: 1px solid #22262c; border-radius: 3px; overflow: hidden;">
            <div style="display: grid; grid-template-columns: 160px 100px 130px 110px 1fr 140px 80px; align-items: center; gap: 12px; padding: 10px 14px; border-bottom: 1px solid #262b31; font: 500 9px/1 'IBM Plex Mono', monospace; color: #767e87; letter-spacing: .08em;">
              <span>TIME RANGE</span>
              <span>DURATION</span>
              <span>CATEGORY</span>
              <span>STATUS</span>
              <span>COMMUNITY VOTES</span>
              <span style="text-align: right;">YOUR VOTE</span>
              <span style="text-align: right;">REPORT</span>
            </div>

            <div v-if="filteredScenes.length === 0" style="padding: 24px; text-align: center; color: #6a737c; font-style: italic;">
              No scene marks in this category.
            </div>

            <div v-for="scene in filteredScenes" :key="'row-'+scene.id"
                 :style="{
                   display: 'grid',
                   gridTemplateColumns: '160px 100px 130px 110px 1fr 140px 80px',
                   alignItems: 'center',
                   gap: '12px',
                   padding: '10px 14px',
                   borderBottom: '1px solid #1c2026',
                   borderLeft: '3px solid ' + scene.color,
                   background: activeSceneHover && activeSceneHover.id === scene.id ? '#161b22' : 'transparent'
                 }"
                 @mouseenter="activeSceneHover = scene"
                 @mouseleave="activeSceneHover = null">
              <span style="font: 500 13px/1 'IBM Plex Mono', monospace; color: #e6e8eb;">{{ scene.range }}</span>
              <span style="font: 400 11px/1 'IBM Plex Mono', monospace; color: #98a0a8;">{{ scene.duration }}</span>
              <span style="display: flex; align-items: center; gap: 6px; font: 500 11px/1 'IBM Plex Sans', sans-serif;" :style="{ color: scene.color }">
                <span :style="{ width: '7px', height: '7px', borderRadius: '1px', background: scene.color }"></span>
                {{ scene.category_label }}
              </span>
              <span>
                <span v-if="scene.is_verified" style="font: 500 9px/1 'IBM Plex Mono', monospace; padding: 3px 6px; border: 1px solid #2e4a36; border-radius: 2px; background: #16211a; color: #7cc08a;">
                  VERIFIED
                </span>
                <span v-else style="font: 500 9px/1 'IBM Plex Mono', monospace; padding: 3px 6px; border: 1px solid #303740; border-radius: 2px; background: #1b1f24; color: #98a0a8;">
                  UNVERIFIED
                </span>
              </span>
              <span style="font: 400 11px/1 'IBM Plex Mono', monospace; color: #98a0a8;">
                <span style="color: #7cc08a;">✓ {{ scene.confirm_votes }}</span>
                <span style="margin: 0 4px; color: #434b54;">/</span>
                <span style="color: #e8938e;">✗ {{ scene.dispute_votes }}</span>
              </span>

              <!-- Vote Buttons -->
              <div style="display: flex; gap: 4px; justify-content: flex-end;">
                <button @click="voteScene(scene, 'confirm')" 
                        :style="{
                          padding: '4px 7px',
                          fontSize: '10px',
                          borderRadius: '2px',
                          border: scene.user_vote === 'confirm' ? '1px solid #2e4a36' : '1px solid #303740',
                          background: scene.user_vote === 'confirm' ? '#16211a' : '#1b1f24',
                          color: scene.user_vote === 'confirm' ? '#7cc08a' : '#98a0a8',
                          cursor: 'pointer'
                        }"
                        title="Confirm timestamp & category">
                  Confirm
                </button>
                <button @click="voteScene(scene, 'dispute')"
                        :style="{
                          padding: '4px 7px',
                          fontSize: '10px',
                          borderRadius: '2px',
                          border: scene.user_vote === 'dispute' ? '1px solid #4a3033' : '1px solid #303740',
                          background: scene.user_vote === 'dispute' ? '#231a1b' : '#1b1f24',
                          color: scene.user_vote === 'dispute' ? '#e8938e' : '#98a0a8',
                          cursor: 'pointer'
                        }"
                        title="Dispute timestamp or category">
                  Dispute
                </button>
              </div>

              <!-- Report Flag -->
              <div style="text-align: right;">
                <button @click="openReport(scene)"
                        style="background: transparent; border: none; cursor: pointer; color: #6a737c; padding: 4px;"
                        title="Report this mark to editors">
                  <svg width="13" height="13" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M3.5 14V2.5h9L10.4 6l2.1 3.5h-9"></path>
                  </svg>
                </button>
              </div>
            </div>
          </div>

          <!-- Add Scene Modal -->
          <div v-if="showAddModal" class="modal-backdrop" @click.self="showAddModal = false">
            <div class="modal-dialog">
              <div class="modal-header">
                <span>ADD SCENE MARK</span>
                <button @click="showAddModal = false" style="background: none; border: none; color: #767e87; cursor: pointer; font-size: 14px;">✕</button>
              </div>
              <div class="modal-body">
                <div style="font-size: 11px; color: #98a0a8;">
                  Time range and category only. No comments or descriptions are collected on marks.
                </div>

                <div v-if="formError" style="padding: 8px 10px; background: #231a1b; border: 1px solid #4a3033; color: #e8938e; border-radius: 2px; font-size: 11px;">
                  {{ formError }}
                </div>

                <div style="display: flex; gap: 10px; align-items: center;">
                  <div style="flex: 1; display: flex; flex-direction: column; gap: 4px;">
                    <label style="font: 500 9px/1 'IBM Plex Mono', monospace; color: #767e87; letter-spacing: 0.08em;">START (HH:MM:SS)</label>
                    <input type="text" v-model="newStart" placeholder="01:02:14"
                           style="background: #1b1f24; border: 1px solid #3a424a; border-radius: 2px; padding: 8px 10px; color: #e6e8eb; font-family: 'IBM Plex Mono', monospace;">
                  </div>
                  <span style="color: #6a737c; margin-top: 14px;">→</span>
                  <div style="flex: 1; display: flex; flex-direction: column; gap: 4px;">
                    <label style="font: 500 9px/1 'IBM Plex Mono', monospace; color: #767e87; letter-spacing: 0.08em;">END (HH:MM:SS)</label>
                    <input type="text" v-model="newEnd" placeholder="01:04:48"
                           style="background: #1b1f24; border: 1px solid #3a424a; border-radius: 2px; padding: 8px 10px; color: #e6e8eb; font-family: 'IBM Plex Mono', monospace;">
                  </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 4px;">
                  <label style="font: 500 9px/1 'IBM Plex Mono', monospace; color: #767e87; letter-spacing: 0.08em;">CATEGORY</label>
                  <div style="display: flex; border: 1px solid #3a424a; border-radius: 2px; overflow: hidden;">
                    <button type="button" @click="newCategory = 'sex_scene'"
                            :style="{
                              flex: 1,
                              padding: '8px 10px',
                              border: 'none',
                              cursor: 'pointer',
                              background: newCategory === 'sex_scene' ? '#231a1b' : '#1b1f24',
                              color: newCategory === 'sex_scene' ? '#e8938e' : '#98a0a8',
                              borderRight: '1px solid #3a424a'
                            }">
                      Sex scene
                    </button>
                    <button type="button" @click="newCategory = 'nudity'"
                            :style="{
                              flex: 1,
                              padding: '8px 10px',
                              border: 'none',
                              cursor: 'pointer',
                              background: newCategory === 'nudity' ? '#221c18' : '#1b1f24',
                              color: newCategory === 'nudity' ? '#e0a878' : '#98a0a8',
                              borderRight: '1px solid #3a424a'
                            }">
                      Nudity
                    </button>
                    <button type="button" @click="newCategory = 'suggestive'"
                            :style="{
                              flex: 1,
                              padding: '8px 10px',
                              border: 'none',
                              cursor: 'pointer',
                              background: newCategory === 'suggestive' ? '#221f1a' : '#1b1f24',
                              color: newCategory === 'suggestive' ? '#e0c078' : '#98a0a8'
                            }">
                      Suggestive
                    </button>
                  </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 8px; margin-top: 6px;">
                  <button type="button" @click="showAddModal = false" class="btn btn-secondary">Cancel</button>
                  <button type="button" @click="submitScene" :disabled="isSubmitting" class="btn btn-primary">
                    {{ isSubmitting ? 'Submitting…' : 'Submit mark' }}
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Report Modal -->
          <div v-if="showReportModal" class="modal-backdrop" @click.self="showReportModal = false">
            <div class="modal-dialog">
              <div class="modal-header">
                <span>FLAG MARK TO EDITORS</span>
                <button @click="showReportModal = false" style="background: none; border: none; color: #767e87; cursor: pointer; font-size: 14px;">✕</button>
              </div>
              <div class="modal-body">
                <div style="font-size: 11px; color: #98a0a8;">
                  Mark: <b>{{ reportTarget.range }}</b> ({{ reportTarget.category_label }})
                </div>
                <div>
                  <label style="font: 500 9px/1 'IBM Plex Mono', monospace; color: #767e87; letter-spacing: 0.08em; display: block; margin-bottom: 4px;">REASON</label>
                  <textarea v-model="reportReason" rows="3" placeholder="Incorrect timestamps, wrong category, or theatrical cut mismatch..."
                            style="width: 100%; background: #1b1f24; border: 1px solid #3a424a; border-radius: 2px; padding: 8px 10px; color: #e6e8eb; font-size: 12px;"></textarea>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 8px;">
                  <button type="button" @click="showReportModal = false" class="btn btn-secondary">Cancel</button>
                  <button type="button" @click="submitReport" class="btn btn-danger">Submit Report</button>
                </div>
              </div>
            </div>
          </div>

        </div>
      `
    });

    app.mount(containerId);
  };
})();
