import { Link } from "@inertiajs/react";
import { navigationMenuTriggerStyle } from "@narsil-ui/Components/NavigationMenu/NavigationMenuTrigger";
import { upperFirst } from "lodash";
import Collapsible from "@narsil-ui/Components/Collapsible/Collapsible";
import CollapsibleContent from "@narsil-ui/Components/Collapsible/CollapsibleContent";
import CollapsibleTrigger from "@narsil-ui/Components/Collapsible/CollapsibleTrigger";
import FavoriteButton from "@narsil-auth/Components/Favorite/FavoriteButton";
import NavigationMenuItem from "@narsil-ui/Components/NavigationMenu/NavigationMenuItem";
import NavigationMenuLink from "@narsil-ui/Components/NavigationMenu/NavigationMenuLink";
import NavigationMenuList from "@narsil-ui/Components/NavigationMenu/NavigationMenuList";
import Svg from "@narsil-ui/Components/Svg/Svg";
import type { MenuNodeModel } from "@narsil-menus/Types";
import type { NodeModel } from "@narsil-tree/Types";

interface NavigationMenuAsideRendererProps {
	nodes: NodeModel<MenuNodeModel>[];
}

const NavigationMenuAsideRenderer = ({ nodes }: NavigationMenuAsideRendererProps) => {
	return nodes.map((node) => {
		return node.children?.length > 0 ? (
			<NavigationMenuItem key={node.id}>
				<Collapsible>
					{node.target.url ? (
						<div className='flex items-center justify-between'>
							<CollapsibleTrigger>
								<Link href={node.target.url}>{upperFirst(node.target.label)}</Link>
							</CollapsibleTrigger>
						</div>
					) : (
						<CollapsibleTrigger>
							{node.target.icon ? <Svg src={node.target.icon.src} /> : null}
							{upperFirst(node.target.label)}
						</CollapsibleTrigger>
					)}

					<CollapsibleContent>
						<NavigationMenuList>
							<NavigationMenuAsideRenderer nodes={node.children} />
						</NavigationMenuList>
					</CollapsibleContent>
				</Collapsible>
			</NavigationMenuItem>
		) : (
			<NavigationMenuItem
				className='group flex w-full items-center'
				key={node.id}
			>
				<NavigationMenuLink
					className={navigationMenuTriggerStyle()}
					asChild={true}
				>
					<Link href={node.target.url}>
						{node.target.icon ? <Svg src={node.target.icon.src} /> : null}
						{upperFirst(node.target.label)}
					</Link>
				</NavigationMenuLink>
				<FavoriteButton />
			</NavigationMenuItem>
		);
	});
};

export default NavigationMenuAsideRenderer;
