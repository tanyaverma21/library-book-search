import { isEmpty } from 'lodash-es';

const { __ } = wp.i18n;
const { PluginDocumentSettingPanel } = wp.editPost;
const { TextControl } = wp.components;
const { dispatch, withSelect } = wp.data;
const el = wp.element.createElement;
const I18N_DOMAIN = 'library-book-search-tool';

function Price(props) {
  var postType = props.postType;
  var meta = props.meta;
  var postTypes = ['book'];
  
  if (isEmpty(postType) || !postTypes.includes(postType)) {
    return null;
  }

  function updateMeta (metaKey, value) {
    dispatch('core/editor').editPost({
        meta: {
          ...meta,
          [metaKey]: value,
        },
    });
  }

  function onChangeBookPrice(e) {
    var bookPrice = e;
    updateMeta('book_price', bookPrice);
  };

  var price = meta?.book_price ?? 0;

  return el(
    PluginDocumentSettingPanel,
    {
        className: 'bookPrice',
        title: __('Book Price', I18N_DOMAIN),
        name: 'book-price',
    },
    el(
      TextControl,
      {
        label: __('Price ($)', I18N_DOMAIN),
        type: 'number',
        onChange: (e) => onChangeBookPrice(e),
        value: price,
        min: 0,
        max: 10000,
        help:__(
            'Enter the price to be considered for the book in numbers, say, 100',
            I18N_DOMAIN,
            ),
        className: 'price',
      },
    )
  );
}
 
export default withSelect(select => {
  const meta = select('core/editor').getEditedPostAttribute('meta');
  const currentPost = select('core/editor').getCurrentPost();

  return {
    meta,
    postType: currentPost?.type,
  };
})(Price);
