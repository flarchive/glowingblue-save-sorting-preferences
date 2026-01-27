import app from 'flarum/forum/app';
import { extend } from 'flarum/common/extend';
import Dropdown from 'flarum/common/components/Dropdown';
import IndexPage from 'flarum/forum/components/IndexPage';
import Button from 'flarum/common/components/Button';

import type ItemList from 'flarum/common/utils/ItemList';
import type Mithril from 'mithril';

export default function replaceSortDropdown() {
	extend(IndexPage.prototype, 'viewItems', function (items: ItemList<Mithril.Children>) {
		if (!app.session.user) return;

		const sortMap = app.discussions.sortMap();

		const sortOptions = Object.keys(sortMap).reduce((acc: any, sortId) => {
			acc[sortId] = app.translator.trans(`core.forum.index_sort.${sortId}_button`);
			return acc;
		}, {});

		let userSort = app.session.user.preferences()?.['discussion_sort'];

		items.setContent(
			'sort',
			<Dropdown
				buttonClassName="Button"
				label={sortOptions[userSort] || Object.keys(sortMap).map((key) => sortOptions[key])[0]}
				accessibleToggleLabel={app.translator.trans('core.forum.index_sort.toggle_dropdown_accessible_label')}
			>
				{Object.keys(sortOptions).map((value) => {
					const label = sortOptions[value];
					const active = (userSort || Object.keys(sortMap)[0]) === value;

					function handleClick() {
						app.search.changeSort.bind(app.search, value)();
						userSort = value;
						app.session.user?.savePreferences({ discussion_sort: value });
					}

					return (
						<Button icon={active ? 'fas fa-check' : true} onclick={handleClick} active={active}>
							{label}
						</Button>
					);
				})}
			</Dropdown>
		);
	});
}
