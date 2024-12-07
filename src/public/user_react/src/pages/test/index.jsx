import { PageContainer } from '@ant-design/pro-components';

export default () => {
    
    return (
        <>
            <PageContainer
                className="sa-page-container"
                ghost
                header={{
                    title: '测试页面',
                    style: { padding: '0 24px 12px' },
                }}
            >
                测试页面
            </PageContainer>
        </>
    )
}
