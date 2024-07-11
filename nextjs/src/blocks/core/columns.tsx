import Blocks, {Block} from "@/blocks/Blocks";
import Columns from "@/components/Columns/Columns";

type Props = {
    attrs: {
        isStackedOnMobile?: boolean
    }
    innerBlocks: {
        innerBlocks: Block[]
    }[]
}

export default function BlockCoreColumns(
    {
        innerBlocks,
        attrs: {
            isStackedOnMobile = true,
        }
    }:Props
){

    return (
        <Columns
            columns={innerBlocks.length}
            isStackedMobile={isStackedOnMobile}
            className="content-layout"
        >
            {innerBlocks.map((column, index) => {
                // core/colum
                return (
                    <div key={index}>
                        <Blocks content={column.innerBlocks} />
                    </div>
                )
            })}

        </Columns>
    )
}