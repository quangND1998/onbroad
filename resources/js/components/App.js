import { Card, Text, ButtonGroup, Button, AppProvider, InlineGrid } from '@shopify/polaris';
import enTranslations from '@shopify/polaris/locales/en.json';
import React from 'react';
export function App() {

    return (
        <AppProvider i18n={enTranslations} >
            <ButtonGroup>
                <Button>Cancel</Button>
                <Button variant="primary">Save</Button>
            </ButtonGroup>

            <SpacingBackground>
                <InlineGrid gap="400" columns={3}>
                    <Placeholder height="320px" />
                    <Placeholder height="320px" />
                    <Placeholder height="320px" />
                </InlineGrid>
            </SpacingBackground>
        </AppProvider>
    );
}
const SpacingBackground = ({
    children,
    width = '100%',
  }) => {
    return (
      <div
        style={{
          background: 'var(--p-color-bg-surface-success)',
          width,
          height: 'auto',
        }}
      >
        {children}
      </div>
    );
  };
  
const Placeholder = ({ label = '', height = 'auto', width = 'auto' }) => {
    return (
        <div
            style={{
                background: 'var(--p-color-border-interactive-subdued)',
                height: height,
                width: width,
                borderRadius: 'inherit',
            }}
        >
            <div
                style={{
                    color: 'var(--p-color-text)',
                }}
            >
                <Text as="p" variant="bodyMd">
                    {label}
                </Text>
            </div>
        </div>
    );
};