/**
* WordPress dependencies.
*/
const { __ } = wp.i18n;
const { RichText } = wp.blockEditor;
const { RangeControl } = wp.components;

/**
* DisplayComponent props.
*
* @typedef DisplayComponent
* @property {()=>void} setAttributes Callable function for saving attribute values.
*/

/**
* DisplayComponent component. Renders editor view of the block.
*
* @param {DisplayComponent} props Component props.
*
* @return {*} JSX markup.
*/
const el = wp.element.createElement;
const I18N_DOMAIN = 'library-book-search-tool';

function DisplayComponent (props) {
  var heading = props.attributes.heading;

  return el(
    'div',
    {
      className: 'search-wrapper',
    },
    el(
      RichText,
      {
        className: 'book-search',
        value: heading,
        placeholder: __('Heading', I18N_DOMAIN),
        tagName: 'h4',
        onChange: title => props.setAttributes({ heading: title })
      },
    ),
    el(
      'table',
      {
        border: 0,
        className: 'search-table',
      },
      el(
        'tr',
        {},
        el(
          'td',
          {
            className: 'search-table-td',
          },
          __('Book Name', I18N_DOMAIN),
          el(
            'input',
            {
              type: 'text',
              className: 'search-input-field',
              disabled: true,
            }
          )
        ),
        el(
          'td',
          {
            className: 'search-table-td',
          },
          __('Author', I18N_DOMAIN),
          el(
            'select',
            {
              className: 'search-input-select',
              disabled: true,
            },
            el(
              'option',
              {
                value: 'All',
              },
              __('All', I18N_DOMAIN)
            )
          )
        )
      ),
      el(
        'tr',
        {},
        el(
          'td',
          {
            className: 'search-table-td',
          },
          __('Publisher Name', I18N_DOMAIN),
          el(
            'select',
            {
              className: 'search-input-select',
              disabled: true,
            },
            el(
              'option',
              {
                value: 'All',
              },
              __('All', I18N_DOMAIN)
            )
          )
        ),
        el(
          'td',
          {
            className: 'search-table-td',
          },
          __('Rating', I18N_DOMAIN),
          el(
            'select',
            {
              className: 'search-input-select',
              disabled: true,
            },
            el(
              'option',
              {
                value: 'All',
              },
              __('All', I18N_DOMAIN)
            )
          )
        )
      ),
      el(
        'tr',
        {},
        el(
          'td',
          {
            className: 'search-table-td',
          },
          __('Price', I18N_DOMAIN),
          el(
            RangeControl,
            {
              className: 'search-input-field',
              disabled: true,
              value: 10000,
              max: 10000,
            }
          )
        ),
      )
    ),
    el(
      'button',
      {
        value: __('Search', I18N_DOMAIN),
        className: 'search-btn',
        disabled: true,
      },
      __('Search', I18N_DOMAIN)
    ),
    el(
      'div',
      {
        className: 'search',
      },
      __('Please check the frontend for the Ajax Search Functionality View.', I18N_DOMAIN),
    ),
  );
};

export default DisplayComponent;
