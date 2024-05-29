type Props = {
    innerHTML: string
    attrs?: {
        displayAsDropdown?: boolean
        showLabel?: boolean
        showPostCounts?: boolean
        type?: "daily" | "weekly" | "monthly" | "yearly"
    }
}

export default function BlockCoreArchives(
    {
        attrs: {
            displayAsDropdown = false,
            showLabel = false,
            showPostCounts = false,
            type = "monthly"
        } = {}
    }: Props
){
    return <div>
        Archives {type}
        <ul>
            <li>May 2024 (1)</li>
            <li>...</li>
        </ul>
    </div>;
}