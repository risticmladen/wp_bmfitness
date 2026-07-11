/**
 * bmfitness/pricing-plans — Gutenberg block (editor side).
 *
 * No build step required: uses the globally available wp.* packages that
 * WordPress enqueues in the block editor automatically.
 *
 * In the editor the block shows a live server-side preview (ServerSideRender).
 * On the frontend it is rendered by bmfitness_pricing_block_render() in PHP.
 */
( function () {
	'use strict';

	var blocks            = wp.blocks;
	var el                = wp.element.createElement;
	var Fragment          = wp.element.Fragment;
	var useSelect         = wp.data.useSelect;
	var useBlockProps     = wp.blockEditor.useBlockProps;
	var __                = wp.i18n.__;
	var InspectorControls = wp.blockEditor.InspectorControls;
	var PanelBody         = wp.components.PanelBody;
	var SelectControl     = wp.components.SelectControl;
	var CheckboxControl   = wp.components.CheckboxControl;
	var ServerSideRender  = wp.serverSideRender;

	blocks.registerBlockType( 'bmfitness/pricing-plans', {

		title:       __( 'Pricing Plans', 'bmfitness' ),
		description: __( 'Display the pricing plan grid for a given section (Fitness or Wellness).', 'bmfitness' ),
		icon:        'money-alt',
		category:    'theme',

		attributes: {
			section_slug: {
				type:    'string',
				default: 'fitness',
			},
			plan_ids: {
				type:    'array',
				default: [],
				items:   { type: 'integer' },
			},
		},

		/**
		 * Editor view: sidebar controls + live server-side preview.
		 */
		edit: function ( props ) {
			var section_slug  = props.attributes.section_slug;
			var plan_ids      = props.attributes.plan_ids || [];
			var setAttributes = props.setAttributes;

			// Fetch all pricing plans from the REST API.
			var allPlans = useSelect( function ( select ) {
				return select( 'core' ).getEntityRecords( 'postType', 'pricing_plan', {
					per_page: 100,
					status:   'publish',
					orderby:  'menu_order',
					order:    'asc',
				} );
			}, [] );

			// Build the plan checkbox list.
			var planList;
			if ( allPlans === null ) {
				planList = el( 'p', { style: { color: '#757575', fontSize: '12px' } },
					__( 'Loading plans…', 'bmfitness' )
				);
			} else if ( allPlans.length === 0 ) {
				planList = el( 'p', { style: { color: '#757575', fontSize: '12px' } },
					__( 'No plans found. Add some via WP Admin → Pricing Plans.', 'bmfitness' )
				);
			} else {
				planList = allPlans.map( function ( plan ) {
					var isChecked = plan_ids.indexOf( plan.id ) !== -1;
					return el( CheckboxControl, {
						key:      plan.id,
						label:    plan.title.rendered,
						checked:  isChecked,
						onChange: function ( checked ) {
							var newIds = checked
								? plan_ids.concat( [ plan.id ] )
								: plan_ids.filter( function ( id ) { return id !== plan.id; } );
							setAttributes( { plan_ids: newIds } );
						},
					} );
				} );
			}

			return el(
				Fragment,
				null,
				// Sidebar panel.
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{
							title:       __( 'Pricing Plans Settings', 'bmfitness' ),
							initialOpen: true,
						},
						// Section selector.
						el( SelectControl, {
							label:    __( 'Section', 'bmfitness' ),
							value:    section_slug,
							options:  [
								{ label: __( 'Fitness',  'bmfitness' ), value: 'fitness'  },
								{ label: __( 'Wellness', 'bmfitness' ), value: 'wellness' },
							],
							onChange: function ( val ) {
								setAttributes( { section_slug: val } );
							},
						} ),
						// Plan picker.
						el( 'div', { style: { marginTop: '16px' } },
							el( 'p', { style: { fontWeight: 600, marginBottom: '4px' } },
								__( 'Show specific plans', 'bmfitness' )
							),
							el( 'p', { style: { color: '#757575', fontSize: '12px', marginBottom: '8px' } },
								__( 'Leave all unchecked to display every plan in the selected section.', 'bmfitness' )
							),
							planList
						)
					)
				),

				// Live preview — wrapped with useBlockProps so className etc. are applied in the editor.
				el( 'div', useBlockProps(),
					el( ServerSideRender, {
						block:      'bmfitness/pricing-plans',
						attributes: props.attributes,
					} )
				)
			);
		},

		/**
		 * Dynamic block — all output comes from the PHP render callback.
		 */
		save: function () {
			return null;
		},
	} );
} )();
