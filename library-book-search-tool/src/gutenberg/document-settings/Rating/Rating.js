import { isEmpty } from 'lodash-es';

const { __ } = wp.i18n;
const { PluginDocumentSettingPanel } = wp.editPost;
const { TextControl } = wp.components;
const { dispatch, withSelect } = wp.data;
const el = wp.element.createElement;
const I18N_DOMAIN = 'library-book-search-tool';

function Rating(props) {
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

  function onChangeBookRating(e) {
    var bookRating = e;
    updateMeta('book_rating', bookRating);
  };

  var rating = meta?.book_rating ?? 0;

  return el(
    PluginDocumentSettingPanel,
    {
      className: 'bookRating',
      title: __('Book Rating', I18N_DOMAIN),
      name: 'book-rating',
    },
    el(
      TextControl,
      {
        label: __('Rating', I18N_DOMAIN),
        type: 'number',
        onChange: (e) => onChangeBookRating(e),
        value: rating,
        min: 0,
        max: 5,
        help:__(
          'Enter the rating to be considered for the book in numbers from 1 to 5',
          I18N_DOMAIN,
          ),
        className: 'rating',
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
})(Rating);
