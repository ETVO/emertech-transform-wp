/**
 * Render **TransformGallery** meta box
 *  
 * @since 1.0
 */
 const {
	data: { 
		useSelect, 
		withSelect, 
		useDispatch, 
		withDispatch },
	plugins: { registerPlugin },
	element: { useState, useEffect },
	blockEditor: { MediaUpload },
	components: { 
		Button, 
		BaseControl,
		TextControl,
	},
	editPost: { PluginDocumentSettingPanel },
	i18n: { __ }
} = wp;




let TransformGallery = (props) => {
	return (
		<>
			<PluginDocumentSettingPanel name="transform-gallery" title="Galeria de fotos">
				{/* <MediaUpload
					type="image"
					value={ gallery }
					multiple = { true }
					gallery = { true }
					onSelect={ (value) => {
						
						var newGallery = JSON.stringify(value);
						console.log(newGallery);
						setGallery(newGallery);
					} }
					render={({ open }) => getImageButton(open, gallery)}
				/> */}
				<TextControl
					type="text"
					value={props.gallery}
					onChange={(value) => props.onMetaFieldChange(value)}
					>
				</TextControl>
			</PluginDocumentSettingPanel>
        </>
    )
}

TransformGallery = withSelect(
	(select) => {
		return {
			gallery: select('core/editor').getEditedPostAttribute('meta')['_transform_gallery']
		}
	}
)(TransformGallery);

TransformGallery = withDispatch(
	(dispatch) => {
		return {
			onMetaFieldChange: (value) => {
				dispatch('core/editor').editPost({meta: {_transform_gallery: value}})
            }
        }
    }
	)(TransformGallery);

function getImageButton (openEvent, value) {
	if (value) {

		const images = [];
		const previewNumber = 3;
		const imageStyle = { height: "60px", width: "60px", objectFit: "cover" };

		var len = (value.length >= previewNumber) ? previewNumber : value.length;

		for(let i = 0; i < len; i++) {
			images.push(
				<img
				style={imageStyle}
				src={value[i]}
				onClick={openEvent}
				/>,
			)
		}

		return (
			[
				images,
				<div className="button-container">
					<Button
						onClick={openEvent}
						className="button button-large select-image-btn"
					>
						{ __('Editar Galeria') }
					</Button>
				</div>
			]
		);
	}
	else {
		return (
			<div className="button-container">
				<Button
					onClick={openEvent}
					className="button button-large"
				>
					{ __('Editar Galeria') }
				</Button>
			</div>
		);
	}
}

if (window.pagenow === 'transform') {
	registerPlugin('emertech-transform', {
		render: TransformGallery,
		icon: null,
	});
}