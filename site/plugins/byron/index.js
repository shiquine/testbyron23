panel.plugin('byron/site', {
  blocks: {
    bigLink: {
      computed: {
        containerClass() {
          return `k-block-bigLink k-block-bigLink--${this.position}`;
        },
        position() {
          return this.content.position;
        },
        styleObject() {
          return {
            display: 'flex',
            fontWeight: 'bold',
            color: '#dc4f3e',
            justifyContent:
              this.position === 'center' ? 'center' : 'flex-start',
          };
        },
        inputStyleObject() {
          return {
            textTransform: 'uppercase',
            textAlign: this.position,
            //  11 is magic
            width: `${this.content.text.length * 11}px`,
            maxWidth: '100%',
            minWidth: '60px',
          };
        },
        dash() {
          return this.position === 'center' ? '—' : '';
        },
      },
      template: `
        <div :class="containerClass" :style="styleObject">
          {{ dash }}
          <k-text-input
            :inline="true"
            :placeholder="field('text').placeholder"
            :value="content.text"
            :style="inputStyleObject"
            :before="dash"
            @input="update({ text: $event })"
          />
          {{ dash }}
        </div>
      `,
    },
  },
});
