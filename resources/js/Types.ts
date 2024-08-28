import { IconModel } from "@narsil-storage/Types";

export type MenuNodeModel = {
	active: boolean;
	background: string;
	created_at: string;
	icon: IconModel;
	id: number;
	label: string;
	updated_at: string;
	url: string;
	visibility: string;
};

export type MenuModel = {
	active: boolean;
	created_at: string;
	id: number;
	name: string;
	type: string;
	updated_at: string;
};
