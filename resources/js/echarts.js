/**
 * Register ECharts core modules required by vue-echarts.
 * Must be imported once before any chart component mounts (e.g. in app.js).
 * Fixes: "Renderer 'undefined' is not imported. Please import it first."
 */
import { use } from 'echarts/core';
import { CanvasRenderer } from 'echarts/renderers';
import { LineChart, BarChart } from 'echarts/charts';
import {
  GridComponent,
  TooltipComponent,
  LegendComponent,
  TitleComponent,
} from 'echarts/components';

use([
  CanvasRenderer,
  LineChart,
  BarChart,
  GridComponent,
  TooltipComponent,
  LegendComponent,
  TitleComponent,
]);
